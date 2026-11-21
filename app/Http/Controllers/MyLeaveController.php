<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\User;
use App\Notifications\LeaveApplied;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MyLeaveController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('my_leave.index', [
            'balances' => self::balances($user),
            'applications' => $user->leaveApplications()->with('approver')->latest()->get(),
        ]);
    }

    /** Annual and sick leave entitlement / used / balance for this year. */
    public static function balances(User $user)
    {
        return collect(LeaveApplication::TYPES)->map(fn ($label, $type) => [
            'label' => __($label),
            'entitled' => $user->leaveEntitlement($type),
            'used' => $user->leaveUsed($type),
            'balance' => $user->leaveBalance($type),
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'type' => ['required', Rule::in(array_keys(LeaveApplication::TYPES))],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'half_day' => ['nullable', 'boolean'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $days = LeaveApplication::workingDays($start, $end);

        if ($days === 0) {
            throw ValidationException::withMessages(['end_date' => __('The selected dates fall on a weekend.')]);
        }
        if ($request->boolean('half_day')) {
            if (! $start->equalTo($end)) {
                throw ValidationException::withMessages(['half_day' => __('Half day is only for a single date.')]);
            }
            $days = 0.5;
        }
        if ($start->year !== $end->year) {
            throw ValidationException::withMessages(['end_date' => __('Please apply separately for each year.')]);
        }

        // Pending applications also count, so a teacher cannot over-apply while waiting for approval.
        $pending = (float) $user->leaveApplications()->where('type', $data['type'])->where('status', 'pending')
            ->whereYear('start_date', $start->year)->sum('days');
        $available = $user->leaveBalance($data['type'], $start->year) - $pending;
        if ($days > $available) {
            throw ValidationException::withMessages(['start_date' => __('Not enough leave: you asked for :days day(s) but have :left left (including pending).', [
                'days' => $days, 'left' => max(0, $available),
            ])]);
        }

        $overlap = $user->leaveApplications()->whereIn('status', ['pending', 'approved'])
            ->whereDate('start_date', '<=', $end)->whereDate('end_date', '>=', $start)->exists();
        if ($overlap) {
            throw ValidationException::withMessages(['start_date' => __('You already have leave on these dates.')]);
        }

        $leave = $user->leaveApplications()->create([
            'type' => $data['type'],
            'start_date' => $start,
            'end_date' => $end,
            'days' => $days,
            'reason' => $data['reason'] ?? null,
            'status' => 'pending',
        ]);

        Notification::send(User::admins()->where('is_active', 1)->get(), new LeaveApplied($leave));

        return redirect()->route('my_leave.index')->with('success', __('Leave application sent for approval.'));
    }

    public function cancel(Request $request, LeaveApplication $leave)
    {
        abort_unless($leave->user_id === $request->user()->id, 403);

        if ($leave->status !== 'pending') {
            return back()->with('error', __('Only pending applications can be cancelled.'));
        }

        $leave->update(['status' => 'cancelled']);

        return redirect()->route('my_leave.index')->with('success', __('Leave application cancelled.'));
    }
}
