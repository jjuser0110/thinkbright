<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\User;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    public function index(Request $request)
    {
        $supervisor = User::where('role_id',3)->get();

        return view('supervisor.index')->with('supervisor',$supervisor);
    }

    public function create()
    {
        return view('supervisor.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username,NULL,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator);
        }
        $request->merge(['password' => Hash::make($request->password),'role_id'=>3]);

        $supervisor = User::create($request->all());

        return redirect()->route('supervisor.index')->withSuccess('Data saved');
    }

    public function edit(User $supervisor)
    {
        return view('supervisor.create')->with('supervisor',$supervisor);
    }

    public function update(Request $request, User $supervisor)
    {
        if($request->password !=null){
            $request->merge(['password' => Hash::make($request->password)]);
        }else{
            $request->request->remove('password');
        }
        // dd($request->all());
        $supervisor->update($request->all());
        return redirect()->route('supervisor.index')->withSuccess('Data updated');
    }

    public function destroy(User $supervisor)
    {
        $supervisor->delete();

        return redirect()->route('supervisor.index')->withSuccess('Data deleted');
    }

}
