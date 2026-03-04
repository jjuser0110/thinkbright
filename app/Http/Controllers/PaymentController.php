<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payment = Payment::all();
        
        return view('payment.index')->with('payment',$payment);
    }

    public function create()
    {
        return view('payment.create');
    }

    public function store(Request $request)
    {
        $array = explode("-",$request->month_year);
        $request->merge(['month'=>$array[1],'year'=>$array[0]]);
        Payment::create($request->all());
        
        return redirect()->route('payment.index');
    }

    public function edit(Payment $payment)
    {
        $payment->month_year=Carbon::parse($payment->year."-".$payment->month)->format('Y-m');
        return view('payment.create')->with('payment',$payment);
    }

    public function update(Request $request, Payment $payment)
    {
        $array = explode("-",$request->month_year);
        $request->merge(['month'=>$array[1],'year'=>$array[0]]);
        $payment->update($request->all());
        
        return redirect()->route('payment.index');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payment.index');
    }
   
}
