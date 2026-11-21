<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $student = Student::with('school')->orderByDesc('is_active')->orderBy('name')->get();

        return view('student.index')->with('student', $student);
    }

    public function create()
    {
        return view('student.create', $this->formData());
    }

    public function store(Request $request)
    {
        Student::create($this->validated($request));

        return redirect()->route('student.index')->with('success', __('Student saved.'));
    }

    public function edit(Student $student)
    {
        return view('student.create', $this->formData() + ['student' => $student]);
    }

    public function update(Request $request, Student $student)
    {
        $student->update($this->validated($request));

        return redirect()->route('student.index')->with('success', __('Student saved.'));
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.index')->with('success', __('Student deleted.'));
    }

    private function formData(): array
    {
        return [
            'school' => School::orderBy('name')->get(),
            'defaultDaycareFee' => Setting::daycareFee(),
            'defaultBathLunchFee' => Setting::bathLunchFee(),
        ];
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'c_name' => ['nullable', 'string', 'max:255'],
            'dob' => ['nullable', 'date'],
            'ic' => ['nullable', 'string', 'max:50'],
            'deposit' => ['nullable', 'numeric', 'min:0'],
            'school_id' => ['nullable', 'exists:schools,id'],
            'level' => ['nullable', 'integer', 'min:0', 'max:20'],
            'class' => ['nullable', 'string', 'max:50'],
            'parent_name' => ['nullable', 'string', 'max:255'],
            'parent_relation' => ['nullable', 'string', 'max:50'],
            'parent_contact' => ['nullable', 'string', 'max:50'],
            'parent_name_2' => ['nullable', 'string', 'max:255'],
            'parent_relation_2' => ['nullable', 'string', 'max:50'],
            'parent_contact_2' => ['nullable', 'string', 'max:50'],
            'is_active' => ['required', 'boolean'],
            'daycare_fee' => ['nullable', 'numeric', 'min:0'],
            'bath_lunch_fee' => ['nullable', 'numeric', 'min:0'],
            'transport_fee' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Unticked checkboxes are not submitted at all.
        foreach (['daycare', 'bath_lunch', 'transport'] as $service) {
            $data[$service] = $request->boolean($service);
        }

        return $data;
    }
}
