<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Extra;
use App\Models\User;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RunningNumber;

class ExtraController extends Controller
{
    public function index(Request $request)
    {
        $date_from = $request->date_from
        ? Carbon::parse($request->date_from)->startOfDay()
        : Carbon::now()->subDays(3)->startOfDay();

        $date_to = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        if(Auth::user()->role_id == 6){
            $extra = Extra::whereBetween('isseued_date', [$date_from, $date_to])->where('created_by_id',Auth::id())->orderBy('created_at','DESC')->get();
        }else {      
            $extra = Extra::whereBetween('isseued_date', [$date_from, $date_to])->orderBy('created_at','DESC')->get();
        }

        $date_from = $date_from->format('Y-m-d');
        $date_to   = $date_to->format('Y-m-d');
        return view('extra.index')->with('extra',$extra)->with('date_from',$date_from)->with('date_to',$date_to);
    }

    public function create()
    {
        return view('extra.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'created_by_id'=>Auth::id(),
        ]);
        $extra = Extra::create($request->all());

        return redirect()->route('extra.index',$extra)->withSuccess('Data saved');
    }

    public function edit(Extra $extra)
    {
        return view('extra.create')->with('extra',$extra);
    }

    public function update(Request $request, Extra $extra)
    {
        $extra->update($request->all());
        return redirect()->route('extra.index')->withSuccess('Data updated');
    }

    public function destroy(Extra $extra)
    {
        $extra->delete();

        return redirect()->route('extra.index')->withSuccess('Data deleted');
    }

}
