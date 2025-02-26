<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $salary = Salary::all();
        
        return view('salary.index')->with('salary',$salary);
    }

    public function create()
    {
        $teacher = User::where('role','!=','superadmin')->get();
        return view('salary.create')->with('teacher',$teacher);
    }

    public function store(Request $request)
    {
        //$now = Carbon::parse($request->year_month);
        
        $array = explode("-",$request->year_month);
        $request->merge(['month'=>$array[1],'year'=>$array[0]]);
        Salary::create($request->all());
        
        return redirect()->route('salary.index');
    }

    public function edit(Salary $salary)
    {
        $teacher = User::where('role','!=','superadmin')->get();
        return view('salary.create')->with('salary',$salary)->with('teacher',$teacher);
    }

    public function update(Request $request, Salary $salary)
    {
        $array = explode("-",$request->year_month);
        $request->merge(['month'=>$array[1],'year'=>$array[0]]);
        //dd($request->all());
        $salary->update($request->all());
        
        return redirect()->route('salary.index');
    }

    public function destroy(Salary $salary)
    {
        $salary->delete();

        return redirect()->route('salary.index');
    }
    public function pdfDetails(Request $request){
        $salary = Salary::with('user')->find($request->salary_id);
        return $salary;
    }
}
