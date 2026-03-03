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

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $operator = User::where('role_id',5)->get();

        return view('operator.index')->with('operator',$operator);
    }

    public function create()
    {
        return view('operator.create');
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
        $request->merge(['password' => Hash::make($request->password),'role_id'=>5]);

        $operator = User::create($request->all());

        return redirect()->route('operator.index')->withSuccess('Data saved');
    }

    public function edit(User $operator)
    {
        return view('operator.create')->with('operator',$operator);
    }

    public function update(Request $request, User $operator)
    {
        if($request->password !=null){
            $request->merge(['password' => Hash::make($request->password)]);
        }else{
            $request->request->remove('password');
        }
        // dd($request->all());
        $operator->update($request->all());
        return redirect()->route('operator.index')->withSuccess('Data updated');
    }

    public function destroy(User $operator)
    {
        $operator->delete();

        return redirect()->route('operator.index')->withSuccess('Data deleted');
    }

}
