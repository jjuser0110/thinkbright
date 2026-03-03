<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\RunningNo;
use App\Models\PrintRecord;
use Carbon\Carbon;
use \NumberFormatter;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $now=Carbon::now();
        $month_filter = Carbon::now()->format('Y-m');
        $month = $now->month;
        $year = $now->year;
        if(isset($request->month_filter)){
            $now=Carbon::parse($request->month_filter);
            $month_filter = Carbon::parse($request->month_filter)->format('Y-m');
            $month = $now->month;
            $year = $now->year;
        }
        $account = Account::where('paid', '!=', null)
        ->whereHas('month', function ($query) use($month,$year){
            $query->where('is_active', 1)->where('month',$month)->where('year',$year);
        })
        ->get();
        
        return view('receipt.index')->with('account',$account)->with('month_filter',$month_filter);
    }

    public function pdfDetails(Request $request){
        $now=Carbon::now();
        $account = Account::find($request->account_id);
        if(isset($account->receipt_no)){
            $receipt_no = $account->receipt_no;
        }else{
            $running_no =RunningNo::where('year',$now->year)->where('month',$now->month)->first();
            if(isset($running_no)){
                $receipt_no = $running_no->year.''.sprintf('%02d',$running_no->month).''.sprintf('%04d',$running_no->increment_no);
            }else{
                $running_no =RunningNo::create(['year'=>$now->year,'month'=>$now->month,'increment_no'=>1]);
                $receipt_no = $running_no->year.''.sprintf('%02d',$running_no->month).''.sprintf('%04d',$running_no->increment_no);
            }
            $account->update(['receipt_no'=>$receipt_no]);
            $running_no->update(['increment_no'=>$running_no->increment_no+1]);
        }
        
        $item = [];
        $total = 0;
        $field = "";
        foreach($request->selected_field as $row){
            switch ($row) {
                case "tuition":
                  $item_name= "Tuition Fees";
                  break;
                case "tuition_extra":
                  $item_name = "Additional Tuition Fees";
                  break;
                case "food":
                    $item_name = "Bath & Lunch";
                  break;
                case "transport":
                    $item_name = "Transport";
                  break;
                case "transport_extra":
                    $item_name = "Additional Transport";
                  break;
                case "deposit":
                    $item_name = "Deposit";
                  break;
                case "material":
                    $item_name = "Material";
                  break;
                case "registration":
                    $item_name = "Registration";
                  break;
                case "extra":
                    $item_name = "Extra";
                    if($request->extra_desc!=''){
                        $item_name = $request->extra_desc;
                    }
                  break;
                case "extra_2":
                    $item_name = "Extra 2";
                    if($request->extra_desc_2!=''){
                        $item_name = $request->extra_desc_2;
                    }
                  break;
                default:
                    $item_name = "Wrong";
            }
            if($account->$row>0){
                $data = ['item_name'=>$item_name,'cost'=>$account->$row];
                $total+=$account->$row;
                array_push($item,$data);
                $field.=$item_name.",";
            }
        }
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        $dateee = date_create($account->month->year."/".$account->month->month."/01");
        $getMonthWord = date_format($dateee,"M");
        $invoice_data = [
            'student_name'=>$account->student->name,
            'receipt_no'=>$account->receipt_no,
            'for'=>$getMonthWord." ".$account->month->year,
            'date_print'=>$now->format('Y-m-d'),
            'item'=>$item,
            'total'=>$total,
            'total_english' =>'RINGGIT MALAYSIA '.strtoupper($f->format($total)).' ONLY',
        ];

        PrintRecord::create(['account_id'=>$account->id,'content'=>$field]);

        return $invoice_data;
    }

    public function create()
    {
        return view('school.create');
    }

    public function store(Request $request)
    {
        School::create($request->all());
        
        return redirect()->route('school.index');
    }

    public function edit(School $school)
    {
        return view('school.create')->with('school',$school);
    }

    public function update(Request $request, School $school)
    {
        $school->update($request->all());
        
        return redirect()->route('school.index');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('school.index');
    }
   
}
