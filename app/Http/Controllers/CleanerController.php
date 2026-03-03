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

class CleanerController extends Controller
{
    public function index(Request $request)
    {
        $cleaner = User::where('role_id',7)->get();

        return view('cleaner.index')->with('cleaner',$cleaner);
    }

    public function create()
    {
        return view('cleaner.create');
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
        $request->merge(['password' => Hash::make($request->password),'role_id'=>7]);

        $cleaner = User::create($request->all());

        return redirect()->route('cleaner.index')->withSuccess('Data saved');
    }

    public function edit(User $cleaner)
    {
        return view('cleaner.create')->with('cleaner',$cleaner);
    }

    public function update(Request $request, User $cleaner)
    {
        if($request->password !=null){
            $request->merge(['password' => Hash::make($request->password)]);
        }else{
            $request->request->remove('password');
        }
        // dd($request->all());
        $cleaner->update($request->all());
        return redirect()->route('cleaner.index')->withSuccess('Data updated');
    }

    public function destroy(User $cleaner)
    {
        $cleaner->delete();

        return redirect()->route('cleaner.index')->withSuccess('Data deleted');
    }

}
