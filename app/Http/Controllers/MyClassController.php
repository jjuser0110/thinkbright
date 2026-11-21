<?php

namespace App\Http\Controllers;

use App\Models\OneToOneClass;
use Illuminate\Http\Request;

class MyClassController extends Controller
{
    /** Teacher: my one-to-one classes and the next two weeks of sessions. */
    public function index(Request $request)
    {
        $user = $request->user();
        $classes = $user->oneToOneClasses()->with('student.school')->currentlyActive()
            ->orderBy('day')->orderBy('start_time')->get();

        // Include classes that start within the next two weeks in the upcoming list.
        $upcomingClasses = $user->oneToOneClasses()->with('student')->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('end_date')->orWhereDate('end_date', '>=', now()))
            ->get();

        return view('my_classes.index', [
            'classes' => $classes,
            'sessions' => OneToOneClass::upcomingSessions($upcomingClasses, 14),
            'commission' => $user->oneToOneCommission(now()->year, now()->month),
        ]);
    }
}
