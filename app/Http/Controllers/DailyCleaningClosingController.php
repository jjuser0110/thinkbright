<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\DailyCleaningClosing;
use App\Models\User;
use App\Models\DailyCleaning;
use App\Models\Customer;
use App\Models\DcWorkerSalary;
use App\Models\Extra;
use App\Models\Expense;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RunningNumber;

class DailyCleaningClosingController extends Controller
{
    public function index(Request $request)
    {
        $date_from = $request->date_from
        ? Carbon::parse($request->date_from)->startOfDay()
        : Carbon::now()->subDays(3)->startOfDay();

        $date_to = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        $daily_cleaning_closing = DailyCleaningClosing::whereBetween('closing_date', [$date_from, $date_to])->orderBy('closing_date','DESC')->get();

        $date_from = $date_from->format('Y-m-d');
        $date_to   = $date_to->format('Y-m-d');
        return view('daily_cleaning_closing.index')->with('daily_cleaning_closing',$daily_cleaning_closing)->with('date_from',$date_from)->with('date_to',$date_to);
    }

    public function create()
    {
        return view('daily_cleaning_closing.create');
    }

    public function store(Request $request)
    {
        $date_from = $request->date_from
            ? Carbon::parse($request->date_from)->startOfDay()
            : Carbon::now()->subDays(3)->startOfDay();

        $date_to = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        // Get all dates between
        $alldateBetween = [];
        $currentDate = $date_from->copy();
        while ($currentDate->lte($date_to)) {
            $alldateBetween[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        $data = [];

        foreach ($alldateBetween as $date) {
            $daily_cleaning_closing = DailyCleaningClosing::whereDate('closing_date', $date)->first();
            if ($daily_cleaning_closing) {
                continue; // Skip if already closed
            }
            
            $daily_cleaning_closing = DailyCleaningClosing::create([
                'closing_date' => $date,
            ]);

            $daily_cleaning_with_no_check = DailyCleaning::whereDate('daily_cleaning_date', $date)->get();

            if ($daily_cleaning_with_no_check->count() > 0) {
                
                $driver_hours = [];
                $cleaner_hours = [];

                foreach ($daily_cleaning_with_no_check as $cleaning) {
                    // DRIVER HOURS
                    if ($cleaning->driver_id) {
                        if (!isset($driver_hours[$cleaning->driver_id])) {
                            $driver_hours[$cleaning->driver_id] = 0;
                        }
                        $driver_hours[$cleaning->driver_id] += $cleaning->duration_hours;
                    }

                    // CLEANER HOURS (array)
                    if (!empty($cleaning->cleaner_ids) && is_array($cleaning->cleaner_ids)) {
                        foreach ($cleaning->cleaner_ids as $cid) {
                            if (!isset($cleaner_hours[$cid])) {
                                $cleaner_hours[$cid] = 0;
                            }
                            $cleaner_hours[$cid] += $cleaning->duration_hours;
                        }
                    }
                }

                // INSERT DRIVER SALARY
                $driver_users = User::whereIn('id', array_keys($driver_hours))->get();

                foreach ($driver_users as $d) {
                    $hours = $driver_hours[$d->id];

                    DcWorkerSalary::create([
                        'check_daily_closing_id' => $daily_cleaning_closing->id,
                        'user_id'       => $d->id,
                        'daily_date'    => $date,
                        'salary_type'   => 'fulltime',
                        'normal'        => $d->salary_per_day,
                        'salary_amount' => $d->salary_per_day,
                    ]);
                }

                // INSERT CLEANER SALARY
                $cleaner_users = User::whereIn('id', array_keys($cleaner_hours))->get();

                foreach ($cleaner_users as $c) {
                    $hours = $cleaner_hours[$c->id];

                    if ($c->salary_per_day == 0) {
                        $salary = round($c->salary_per_hour * $hours, 2);
                        $type = "parttime";
                    } else {
                        $salary = $c->salary_per_day;
                        $type = "fulltime";
                    }

                    DcWorkerSalary::create([
                        'check_daily_closing_id' => $daily_cleaning_closing->id,
                        'user_id'       => $c->id,
                        'daily_date'    => $date,
                        'salary_type'   => $type,
                        'duration_hours'=> $hours,
                        'normal'        => $salary,
                        'salary_amount' => $salary,
                    ]);
                }
            }

            // DAILY SUMMARY
            $daily_cleaning = DailyCleaning::whereDate('daily_cleaning_date', $date)->get();
            $no_of_customer = $daily_cleaning->groupBy('customer_name')->select('customer_name')->count();
            $total_customer = Customer::whereDate('created_at', $date)->count();
            $total_cleaning = $daily_cleaning->count();
            $total_sales = $daily_cleaning->sum('sales');
            $total_sst = $daily_cleaning->sum('sst_amount');
            $after_sst = $daily_cleaning->sum('profit');
            $tools = Extra::whereDate('isseued_date', $date)->sum('amount');
            $expenses = Expense::whereDate('isseued_date', $date)->sum('amount');
            $total_salary = DcWorkerSalary::whereDate('daily_date', $date)->sum('salary_amount');

            $final_profit = round($after_sst + $tools - $expenses - $total_salary, 2);

            $daily_cleaning_closing->update([
                'no_of_customer'    => $no_of_customer,
                'new_customer'    => $total_customer,
                'cleaning_count' => $total_cleaning,
                'total_sales'       => $total_sales,
                'total_sst'         => $total_sst,
                'after_sst'      => $after_sst,
                'cleaning_tool'       => $tools,
                'expenses'    => $expenses,
                'salary'      => $total_salary,
                'profit'      => $final_profit,
            ]);
        }

        return redirect()->route('daily_cleaning_closing.index',$daily_cleaning_closing)->withSuccess('Data saved');
    }

    public function destroy(DailyCleaningClosing $daily_cleaning_closing)
    {
        $daily_cleaning_closing->delete();

        return redirect()->route('daily_cleaning_closing.index')->withSuccess('Data deleted');
    }

}
