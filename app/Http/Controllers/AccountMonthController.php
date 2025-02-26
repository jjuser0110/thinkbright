<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AccountMonth;
use App\Models\ExtraReceived;
use App\Models\Payment;
use App\Models\Account;
use App\Models\Food;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendWhatsapp;

class AccountMonthController extends Controller
{
    public function index(Request $request)
    {
        $account_month = AccountMonth::where('is_active',1)->orderBy('id','DESC')->get();
        foreach($account_month as $a){
            $a->total = $a->accounts->sum('total');
            $a->paid = $a->accounts->where('paid','!=',null)->sum('total');
            $a->extra_received = ExtraReceived::where('month',$a->month)->where('year',$a->year)->sum('amount');
            $a->payment = Payment::where('month',$a->month)->where('year',$a->year)->sum('amount');
            $a->food = Food::where('month',$a->month)->where('year',$a->year)->sum('total');
            $a->salary = Salary::where('month',$a->month)->where('year',$a->year)->sum('employer_total_paid');
            $a->outstanding = $a->paid+$a->extra_received-$a->payment-$a->food-$a->salary;
        }

        //dd($account_month);
        
        return view('account_month.index')->with('account_month',$account_month);
    }

    public function create()
    {
        $account_month = AccountMonth::all();
        return view('account_month.create')->with('account_month',$account_month);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $array = explode("-",$request->month);
        $request->merge(['month'=>$array[1],'year'=>$array[0]]);
        $account_month = AccountMonth::create($request->all());
        if($request->duplicate_from >0){
            $findaccount = Account::where('account_month_id',$request->duplicate_from)->get();
            foreach($findaccount as $acc){
                $data = [
                    'student_id'=>$acc->student_id,
                    'account_month_id'=>$account_month->id  ,
                    'tuition'=>$acc->tuition,
                    'tuition_extra'=>$acc->tuition_extra,
                    'food'=>$acc->food,
                    'transport'=>$acc->transport,
                    'transport_extra'=>$acc->transport_extra,
                    'deposit'=>$acc->deposit,
                    'material'=>$acc->material,
                    'registration'=>$acc->registration,
                    'extra'=>$acc->extra,
                    'extra_2'=>$acc->extra_2,
                    'total'=>$acc->total,
                    'paid'=>null,
                    'sent'=>null,
                    'remarks'=>null,
                    'receipt_no'=>null,
                ];
                Account::create($data);
            }
        }else{
            $students = Student::where('is_active',1)->get();;
            foreach($students as $s){
                Account::create(['student_id'=>$s->id,'account_month_id'=>$account_month->id]);
            }
        }
        
        return redirect()->route('account_month.index');
    }

    public function sync(AccountMonth $account_month)
    {
        $students = Student::where('is_active',1)->get();
        foreach($students as $s){
            $findAccount = Account::where('student_id',$s->id)->where('account_month_id',$account_month->id)->first();
            if(!isset($findAccount)){
                Account::create(['student_id'=>$s->id,'account_month_id'=>$account_month->id]);
            }
        }
        return redirect()->route('account_month.index');
    }

    public function destroy(AccountMonth $account_month)
    {
        foreach($account_month->accounts as $a){
            $a->delete();
        }
        $account_month->delete();

        return redirect()->route('account_month.index');
    }

    public function destroy_specific_acc(Account $account)
    {
        $account->delete();

        return redirect()->back();
    }

    public function edit(AccountMonth $account_month)
    {
        return view('account_month.edit')->with('account_month',$account_month);
    }

    public function update($table_name, $table_value)
    {
        $array = explode("~",$table_name);
        $column_name = $array[0];
        $table_id = $array[1];
        if($table_value == 'z'){
            $table_value=null;
        }
        $account = Account::find($table_id);
        if($column_name =="paid" ||$column_name =="sent" ){
            if($table_value == "yes"){
                $account->update([$column_name=>Carbon::now()]);
            }else{
                $account->update([$column_name=>null]);
            }
            $data = [
                'account'=>$account,
                'column_name'=>'tr~'.$table_id
            ];
            return $data;
        }else{
            $account->update([$column_name=>$table_value]);
    
            $total = $account->tuition + $account->tuition_extra + $account->food + $account->transport + $account->transport_extra + $account->deposit + $account->material + $account->registration + $account->extra + $account->extra_2;
            
            $account->update(['total'=>$total]);
            
            $data = [
                'total'=>$total,
                'column_name'=>'total~'.$table_id
            ];
            return $data;
        }

        
        // if($column_name =="sent"){
        //     $user = Auth::user();
        //     $user->notify(new SendWhatsapp($user));
        // }

    }
   
}
