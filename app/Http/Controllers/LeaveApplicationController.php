<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Notifications\LeaveDecided;
use Illuminate\Http\Request;

class LeaveApplicationController extends Controller
{
    /** Admin: all leave applications, filtered by status. */
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        $applications = LeaveApplication::with(['user', 'approver'])
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        return view('leave.index', [
            'applications' => $applications,
            'status' => $status,
            'counts' => LeaveApplication::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function approve(Request $request, LeaveApplication $leave)
    {
        return $this->decide($request, $leave, 'approved');
    }

    public function reject(Request $request, LeaveApplication $leave)
    {
        return $this->decide($request, $leave, 'rejected');
    }

    private function decide(Request $request, LeaveApplication $leave, string $status)
    {
        $data = $request->validate(['admin_remarks' => ['nullable', 'string', 'max:255']]);

        if ($leave->status !== 'pending') {
            return back()->with('error', __('This application has already been processed.'));
        }

        $leave->update([
            'status' => $status,
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
            'admin_remarks' => $data['admin_remarks'] ?? null,
        ]);

        $leave->user->notify(new LeaveDecided($leave));

        return back()->with('success', $status === 'approved'
            ? __('Leave approved for :name.', ['name' => $leave->user->name])
            : __('Leave rejected for :name.', ['name' => $leave->user->name]));
    }
}
