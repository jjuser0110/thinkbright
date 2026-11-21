<?php

namespace App\Http\Controllers;

use App\Models\AccountMonth;
use App\Models\DaycareTimetable;
use App\Models\LeaveApplication;
use App\Models\OneToOneClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $todayTimetable = now()->isWeekday()
            ? DaycareTimetable::with('teacher')->where('day', now()->dayOfWeekIso)->orderBy('start_time')->get()
            : collect();

        return $user->isAdmin()
            ? $this->admin($todayTimetable)
            : $this->teacher($user, $todayTimetable);
    }

    private function admin($todayTimetable)
    {
        $active = Student::active();

        $stats = [
            ['fa-user-graduate', __('Active students'), (clone $active)->count(), route('student.index')],
            ['fa-child-reaching', __('Daycare'), (clone $active)->where('daycare', true)->count(), route('enrolment.index')],
            ['fa-utensils', __('Bath & lunch'), (clone $active)->where('bath_lunch', true)->count(), route('enrolment.index')],
            ['fa-van-shuttle', __('Transport'), (clone $active)->where('transport', true)->count(), route('enrolment.index')],
            ['fa-chalkboard-user', __('1-to-1 classes'), OneToOneClass::currentlyActive()->count(), route('one_to_one.index')],
            ['fa-users', __('Teachers'), User::teachers()->where('is_active', 1)->count(), route('user.index')],
        ];

        // Current month if it exists, otherwise the latest month that is not in the future.
        $month = AccountMonth::where('is_active', 1)
            ->whereRaw('CAST(year AS UNSIGNED) * 100 + CAST(month AS UNSIGNED) <= ?', [now()->year * 100 + now()->month])
            ->orderByRaw('CAST(year AS UNSIGNED) DESC, CAST(month AS UNSIGNED) DESC')
            ->with('accounts')
            ->first();
        $billing = $month ? [
            'label' => $month->month.'/'.$month->year,
            'month' => $month,
            'billed' => $month->accounts->sum('total'),
            'paid' => $month->accounts->whereNotNull('paid')->sum('total'),
            'unpaid_count' => $month->accounts->whereNull('paid')->where('total', '>', 0)->count(),
        ] : null;

        $classes = OneToOneClass::with(['student', 'teacher'])->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('end_date')->orWhereDate('end_date', '>=', now()))
            ->get();

        return view('dashboard.admin', [
            'stats' => $stats,
            'billing' => $billing,
            'pendingLeave' => LeaveApplication::with('user')->where('status', 'pending')->oldest()->take(5)->get(),
            'onLeaveToday' => LeaveApplication::with('user')->where('status', 'approved')
                ->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->get(),
            'sessions' => OneToOneClass::upcomingSessions($classes, 3),
            'todayTimetable' => $todayTimetable,
        ]);
    }

    private function teacher(User $user, $todayTimetable)
    {
        $classes = $user->oneToOneClasses()->with('student')->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('end_date')->orWhereDate('end_date', '>=', now()))
            ->get();

        return view('dashboard.teacher', [
            'sessions' => OneToOneClass::upcomingSessions($classes, 7),
            'balances' => MyLeaveController::balances($user),
            'commission' => $user->oneToOneCommission(now()->year, now()->month),
            'classCount' => $user->oneToOneClasses()->currentlyActive()->count(),
            'pendingLeave' => $user->leaveApplications()->where('status', 'pending')->count(),
            'todayTimetable' => $todayTimetable,
        ]);
    }
}
