<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\KodKerja;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KodController extends Controller
{
    public function index(Request $request)
    {
        $kod = KodKerja::all();

        return view('kod.index')->with('kod',$kod);
    }

    public function create()
    {
        return view('kod.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:kod_kerjas,code,NULL,id,deleted_at,NULL',
            'boss_amount' => 'required|numeric',
            'worker_amount' => 'required|numeric',
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->boss_amount < $request->worker_amount) {
                $validator->errors()->add('boss_amount', 'Boss amount cannot be smaller than worker amount.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $request->merge(['earn_amount' => $request->boss_amount - $request->worker_amount]);

        $kod = KodKerja::create($request->all());

        return redirect()->route('kod.index')->withSuccess('Data saved');
    }

    public function edit(KodKerja $kod)
    {
        return view('kod.create')->with('kod',$kod);
    }

    public function update(Request $request, KodKerja $kod)
    {
        
        $validator = Validator::make($request->all(), [
            'boss_amount' => 'required|numeric',
            'worker_amount' => 'required|numeric',
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->boss_amount < $request->worker_amount) {
                $validator->errors()->add('boss_amount', 'Boss amount cannot be smaller than worker amount.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $request->merge(['earn_amount' => $request->boss_amount - $request->worker_amount]);

        $kod->update($request->all());
        return redirect()->route('kod.index')->withSuccess('Data updated');
    }

    public function destroy(KodKerja $kod)
    {
        $kod->delete();

        return redirect()->route('kod.index')->withSuccess('Data deleted');
    }

}
