<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use App\Models\User;
use App\Models\DailyActivity;
use App\Models\DailyCleaning;
use App\Models\Extra;
use App\Models\Expense;
use App\Models\DcWorkerSalary;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $date_from = $request->date_from
        ? Carbon::parse($request->date_from)->startOfDay()
        : Carbon::now()->subDays(3)->startOfDay();

        $date_to = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();
        
        $todayActivities = DailyActivity::whereBetween('daily_activity_date', [$date_from, $date_to])->get();
        $todayActivitiesCount = $todayActivities->count();
        $todayProfit = $todayActivities->sum('profit');
        $todaySales = $todayActivities->sum('sales_total');
        $todayExpenses = $todayActivities->sum('expenses_total');


        //cleaning
        $daily_cleaning = DailyCleaning::whereBetween('daily_cleaning_date', [$date_from, $date_to])->get();
        $daily_cleaning_count = $daily_cleaning->count();
        $daily_cleaning_sales = $daily_cleaning->sum('sales');
        $daily_sst = $daily_cleaning->sum('sst_amount');
        $daily_cleaning_profit = $daily_cleaning->sum('profit');
        $expenses = Expense::whereBetween('isseued_date', [$date_from, $date_to])->sum('amount');
        $extra = Extra::whereBetween('isseued_date', [$date_from, $date_to])->sum('amount');
        $worker_salary = DcWorkerSalary::whereBetween('daily_date', [$date_from, $date_to])->sum('salary_amount');
        $final_profit = round($daily_cleaning_profit + $extra - $expenses - $worker_salary,2);


        $date_from = $date_from->format('Y-m-d');
        $date_to   = $date_to->format('Y-m-d');

        return view('home',compact('date_from', 'date_to', 'todayProfit', 'todaySales', 'todayExpenses', 'todayActivitiesCount','daily_cleaning_count','daily_cleaning_sales','daily_cleaning_profit','expenses','extra','final_profit','daily_sst','worker_salary'));
    }

    public function change_password(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


        if ($validator->fails()) {
            $message = "";
            foreach($validator->messages()->messages() as $m){
                foreach($m as $mm){
                    $message .=$mm.'\n';
                }
            }
            return redirect()->back()->withInfo($message);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('home')->withSuccess('Password changed successfully.');
    }
}
