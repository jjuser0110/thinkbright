<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\School;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $student = Student::all();
        
        return view('student.index')->with('student',$student);
    }

    public function create()
    {
        $school = School::all();
        return view('student.create')->with('school',$school);
    }

    public function store(Request $request)
    {
        Student::create($request->all());
        
        return redirect()->route('student.index');
    }

    public function edit(Student $student)
    {
        $school = School::all();
        return view('student.create')->with('school',$school)->with('student',$student);
    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
        
        return redirect()->route('student.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.index');
    }
   
}
