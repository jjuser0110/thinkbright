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

    /** JSON: the teacher's basic salary and 1-to-1 commission for a month (YYYY-MM). */
    public function prefill(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'year_month' => ['required', 'date_format:Y-m'],
        ]);
        [$year, $month] = array_map('intval', explode('-', $data['year_month']));
        $teacher = User::findOrFail($data['user_id']);
        $classes = $teacher->oneToOneClasses()->activeInMonth($year, $month)->count();
        $commission = $teacher->oneToOneCommission($year, $month);

        return response()->json([
            'basic' => $teacher->basic_salary,
            'commission' => number_format($commission, 2, '.', ''),
            'message' => __(':name: :count 1-to-1 class(es), commission RM:amount', [
                'name' => $teacher->name,
                'count' => $classes,
                'amount' => number_format($commission, 2),
            ]),
        ]);
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
