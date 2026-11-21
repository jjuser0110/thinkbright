<?php

namespace App\Http\Controllers;

use App\Models\OneToOneClass;
use App\Models\Student;
use App\Models\User;
use App\Notifications\OneToOneAssigned;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OneToOneClassController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = $request->integer('teacher_id') ?: null;
        $status = $request->input('status', 'active');

        $classes = OneToOneClass::with(['student', 'teacher'])
            ->when($teacherId, fn ($q) => $q->where('teacher_id', $teacherId))
            ->when($status === 'active', fn ($q) => $q->currentlyActive())
            ->when($status === 'ended', fn ($q) => $q->where(fn ($w) => $w->where('is_active', false)->orWhereDate('end_date', '<', now())))
            ->orderBy('day')->orderBy('start_time')
            ->get();

        return view('one_to_one.index', [
            'classes' => $classes,
            'teachers' => $this->teachers(),
            'teacherId' => $teacherId,
            'status' => $status,
        ]);
    }

    public function create()
    {
        return view('one_to_one.form', $this->formData(new OneToOneClass([
            'start_date' => now()->startOfMonth(),
            'is_active' => true,
        ])));
    }

    public function store(Request $request)
    {
        $class = OneToOneClass::create($this->validated($request));
        $class->teacher->notify(new OneToOneAssigned($class));

        return redirect()->route('one_to_one.index')->with('success', __('1-to-1 class saved.'));
    }

    public function edit(OneToOneClass $one_to_one)
    {
        return view('one_to_one.form', $this->formData($one_to_one));
    }

    public function update(Request $request, OneToOneClass $one_to_one)
    {
        $one_to_one->fill($this->validated($request));
        $notifyTeacher = $one_to_one->isDirty(['teacher_id', 'day', 'start_time', 'end_time', 'student_id']);
        $teacherChanged = $one_to_one->isDirty('teacher_id');
        $one_to_one->save();

        if ($notifyTeacher && $one_to_one->is_active) {
            $one_to_one->teacher->notify(new OneToOneAssigned($one_to_one, updated: ! $teacherChanged));
        }

        return redirect()->route('one_to_one.index')->with('success', __('1-to-1 class saved.'));
    }

    public function destroy(OneToOneClass $one_to_one)
    {
        $one_to_one->delete();

        return redirect()->route('one_to_one.index')->with('success', __('1-to-1 class deleted.'));
    }

    private function teachers()
    {
        return User::whereIn('role', ['teacher', 'admin'])->where('is_active', 1)->orderBy('name')->get(['id', 'name']);
    }

    private function formData(OneToOneClass $class): array
    {
        return [
            'class' => $class,
            'teachers' => $this->teachers(),
            'students' => Student::active()->orderBy('name')->get(['id', 'name', 'c_name']),
        ];
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:users,id'],
            'subject' => ['required', 'string', 'max:100'],
            'day' => ['required', 'integer', Rule::in(array_keys(OneToOneClass::DAYS))],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'commission_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
