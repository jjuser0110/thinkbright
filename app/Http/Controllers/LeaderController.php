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

class LeaderController extends Controller
{
    public function index(Request $request)
    {
        $leader = User::where('role_id',4)->get();

        return view('leader.index')->with('leader',$leader);
    }

    public function create()
    {
        return view('leader.create');
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
        $request->merge(['password' => Hash::make($request->password),'role_id'=>4]);

        $leader = User::create($request->all());

        return redirect()->route('leader.index')->withSuccess('Data saved');
    }

    public function edit(User $leader)
    {
        return view('leader.create')->with('leader',$leader);
    }

    public function update(Request $request, User $leader)
    {
        if($request->password !=null){
            $request->merge(['password' => Hash::make($request->password)]);
        }else{
            $request->request->remove('password');
        }
        // dd($request->all());
        $leader->update($request->all());
        return redirect()->route('leader.index')->withSuccess('Data updated');
    }

    public function destroy(User $leader)
    {
        $leader->delete();

        return redirect()->route('leader.index')->withSuccess('Data deleted');
    }

}
