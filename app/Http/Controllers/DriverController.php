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

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $driver = User::where('role_id',6)->get();

        return view('driver.index')->with('driver',$driver);
    }

    public function create()
    {
        return view('driver.create');
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
        $request->merge(['password' => Hash::make($request->password),'role_id'=>6]);

        $driver = User::create($request->all());

        return redirect()->route('driver.index')->withSuccess('Data saved');
    }

    public function edit(User $driver)
    {
        return view('driver.create')->with('driver',$driver);
    }

    public function update(Request $request, User $driver)
    {
        if($request->password !=null){
            $request->merge(['password' => Hash::make($request->password)]);
        }else{
            $request->request->remove('password');
        }
        // dd($request->all());
        $driver->update($request->all());
        return redirect()->route('driver.index')->withSuccess('Data updated');
    }

    public function destroy(User $driver)
    {
        $driver->delete();

        return redirect()->route('driver.index')->withSuccess('Data deleted');
    }

}
