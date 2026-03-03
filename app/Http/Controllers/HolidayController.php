<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Holiday;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $holiday = Holiday::all();

        return view('holiday.index')->with('holiday',$holiday);
    }

    public function create()
    {
        return view('holiday.create');
    }

    public function store(Request $request)
    {
        $holiday = Holiday::create($request->all());

        return redirect()->route('holiday.index')->withSuccess('Data saved');
    }

    public function edit(Holiday $holiday)
    {
        return view('holiday.create')->with('holiday',$holiday);
    }

    public function update(Request $request, Holiday $holiday)
    {
        $holiday->update($request->all());
        return redirect()->route('holiday.index')->withSuccess('Data updated');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return redirect()->route('holiday.index')->withSuccess('Data deleted');
    }

}
