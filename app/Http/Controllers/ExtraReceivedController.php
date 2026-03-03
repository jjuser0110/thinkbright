<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\ExtraReceived;
use Carbon\Carbon;

class ExtraReceivedController extends Controller
{
    public function index(Request $request)
    {
        $extra_received = ExtraReceived::all();
        
        return view('extra_received.index')->with('extra_received',$extra_received);
    }

    public function create()
    {
        return view('extra_received.create');
    }

    public function store(Request $request)
    {
        $array = explode("-",$request->month_year);
        $request->merge(['month'=>$array[1],'year'=>$array[0]]);
        ExtraReceived::create($request->all());
        
        return redirect()->route('extra_received.index');
    }

    public function edit(ExtraReceived $extra_received)
    {
        $extra_received->month_year=Carbon::parse($extra_received->year."-".$extra_received->month)->format('Y-m');
        return view('extra_received.create')->with('extra_received',$extra_received);
    }

    public function update(Request $request, ExtraReceived $extra_received)
    {
        $array = explode("-",$request->month_year);
        $request->merge(['month'=>$array[1],'year'=>$array[0]]);
        $extra_received->update($request->all());
        
        return redirect()->route('extra_received.index');
    }

    public function destroy(ExtraReceived $extra_received)
    {
        $extra_received->delete();

        return redirect()->route('extra_received.index');
    }
   
}
