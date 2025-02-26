<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $school = School::all();
        
        return view('school.index')->with('school',$school);
    }

    public function create()
    {
        return view('school.create');
    }

    public function store(Request $request)
    {
        School::create($request->all());
        
        return redirect()->route('school.index');
    }

    public function edit(School $school)
    {
        return view('school.create')->with('school',$school);
    }

    public function update(Request $request, School $school)
    {
        $school->update($request->all());
        
        return redirect()->route('school.index');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('school.index');
    }
   
}
