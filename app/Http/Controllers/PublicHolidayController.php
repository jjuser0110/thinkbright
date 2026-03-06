<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PublicHoliday;

class PublicHolidayController extends Controller
{
    public function index(Request $request)
    {
        $public_holiday = PublicHoliday::all();
        return view('public_holiday.index')->with('public_holiday', $public_holiday);
    }

    public function create()
    {
        return view('public_holiday.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'is_active' => 'required'
        ]);

        PublicHoliday::create([
            'name' => $request->name,
            'date' => $request->date,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('public_holiday.index');
    }

    public function edit(PublicHoliday $public_holiday)
    {
        return view('public_holiday.create')->with('public_holiday', $public_holiday);
    }

    public function update(Request $request, PublicHoliday $public_holiday)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'is_active' => 'required'
        ]);

        $public_holiday->update([
            'name' => $request->name,
            'date' => $request->date,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('public_holiday.index');
    }

    public function destroy(PublicHoliday $public_holiday)
    {
        $public_holiday->delete();
        return redirect()->route('public_holiday.index');
    }
}