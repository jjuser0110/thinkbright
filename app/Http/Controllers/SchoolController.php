<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $school = School::orderBy('name')->get();

        return view('school.index')->with('school', $school);
    }

    public function create()
    {
        return view('school.create');
    }

    public function store(Request $request)
    {
        School::create($this->validated($request));

        return redirect()->route('school.index')->with('success', __('School saved.'));
    }

    public function edit(School $school)
    {
        return view('school.create')->with('school', $school);
    }

    public function update(Request $request, School $school)
    {
        $school->update($this->validated($request));

        return redirect()->route('school.index')->with('success', __('School saved.'));
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('school.index')->with('success', __('School deleted.'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'transport_fee' => ['nullable', 'numeric', 'min:0'],
        ]);
    }
}
