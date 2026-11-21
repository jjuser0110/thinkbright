<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class DaycareEnrolmentController extends Controller
{
    /** Active students who take at least one service, with their effective monthly charges. */
    public function index(Request $request)
    {
        $schoolId = $request->integer('school_id') ?: null;

        $students = Student::active()
            ->with('school')
            ->where(fn ($q) => $q->where('daycare', true)->orWhere('bath_lunch', true)->orWhere('transport', true))
            ->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))
            ->orderBy('name')
            ->get()
            ->each(fn ($s) => $s->charges = $s->monthlyCharges());

        $totals = [
            'daycare' => $students->where('daycare', true)->count(),
            'bath_lunch' => $students->where('bath_lunch', true)->count(),
            'transport' => $students->where('transport', true)->count(),
            'amount' => $students->sum(fn ($s) => $s->charges['total']),
        ];

        return view('enrolment.index', [
            'students' => $students,
            'totals' => $totals,
            'schools' => School::orderBy('name')->get(['id', 'name']),
            'schoolId' => $schoolId,
        ]);
    }
}
