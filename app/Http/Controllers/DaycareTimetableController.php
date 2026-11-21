<?php

namespace App\Http\Controllers;

use App\Models\DaycareTimetable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DaycareTimetableController extends Controller
{
    /** Admin: manage the weekly timetable. */
    public function index()
    {
        return view('timetable.index', [
            'week' => DaycareTimetable::weekly(),
            'editable' => true,
        ]);
    }

    /** Everyone: read-only weekly timetable. */
    public function view()
    {
        return view('timetable.view', [
            'week' => DaycareTimetable::weekly(),
            'editable' => false,
        ]);
    }

    public function create(Request $request)
    {
        return view('timetable.form', [
            'slot' => new DaycareTimetable(['day' => $request->integer('day') ?: 1]),
            'teachers' => $this->teachers(),
        ]);
    }

    public function store(Request $request)
    {
        DaycareTimetable::create($this->validated($request));

        return redirect()->route('timetable.index')->with('success', __('Timetable slot saved.'));
    }

    public function edit(DaycareTimetable $timetable)
    {
        return view('timetable.form', ['slot' => $timetable, 'teachers' => $this->teachers()]);
    }

    public function update(Request $request, DaycareTimetable $timetable)
    {
        $timetable->update($this->validated($request));

        return redirect()->route('timetable.index')->with('success', __('Timetable slot saved.'));
    }

    public function destroy(DaycareTimetable $timetable)
    {
        $timetable->delete();

        return redirect()->route('timetable.index')->with('success', __('Timetable slot deleted.'));
    }

    private function teachers()
    {
        return User::whereIn('role', ['teacher', 'admin'])->where('is_active', 1)->orderBy('name')->get(['id', 'name']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'day' => ['required', 'integer', Rule::in(array_keys(DaycareTimetable::DAYS))],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'activity' => ['required', 'string', 'max:255'],
            'teacher_id' => ['nullable', 'exists:users,id'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
