<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\User;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RunningNumber;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $date_from = $request->date_from
        ? Carbon::parse($request->date_from)->startOfDay()
        : Carbon::now()->subDays(3)->startOfDay();

        $date_to = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        if(Auth::user()->role_id == 6){
            $expense = Expense::whereBetween('isseued_date', [$date_from, $date_to])->where('created_by_id',Auth::id())->orderBy('created_at','DESC')->get();
        }else {      
            $expense = Expense::whereBetween('isseued_date', [$date_from, $date_to])->orderBy('created_at','DESC')->get();
        }

        $date_from = $date_from->format('Y-m-d');
        $date_to   = $date_to->format('Y-m-d');
        return view('expense.index')->with('expense',$expense)->with('date_from',$date_from)->with('date_to',$date_to);
    }

    public function create()
    {
        return view('expense.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'created_by_id'=>Auth::id(),
        ]);
        $expense = Expense::create($request->all());

        return redirect()->route('expense.index',$expense)->withSuccess('Data saved');
    }

    public function edit(Expense $expense)
    {
        return view('expense.create')->with('expense',$expense);
    }

    public function update(Request $request, Expense $expense)
    {
        $expense->update($request->all());
        return redirect()->route('expense.index')->withSuccess('Data updated');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expense.index')->withSuccess('Data deleted');
    }

}
