<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\DailyActivity;
use App\Models\DailyActivityItem;
use App\Models\User;
use App\Models\KodKerja;
use App\Models\WorkerSalary;
use App\Models\DailyCleaning;
use App\Models\Extra;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\CleanerKpi;
use App\Models\DcWorkerSalary;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RunningNumber;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    public function sales_report(Request $request)
    {
        $date_from = $request->date_from
        ? Carbon::parse($request->date_from)->startOfDay()
        : Carbon::now()->subDays(3)->startOfDay();

        $date_to = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        $alldateBetween = [];
        $currentDate = $date_from->copy();

        while ($currentDate->lte($date_to)) {
            $alldateBetween[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        $data = [];

        foreach ($alldateBetween as $date) {
            // Eager load items to avoid N+1 queries
            $daily_activities = DailyActivity::with('items')
                ->whereDate('daily_activity_date', $date)
                ->get();

            $total_activity = $daily_activities->count();
            $total_activity_items = $daily_activities->sum(function ($activity) {
                return $activity->items->count();
            });

            $data[] = [
                'date' => $date,
                'total_activity' => $total_activity,
                'total_activity_items' => $total_activity_items,
                'total_sale' => $daily_activities->sum('sales_total'),
                'total_expenses' => $daily_activities->sum('salary'),
                'total_profit' => $daily_activities->sum('profit'),
            ];
        }

        return view('report.sales_report', [
            'date_from' => $date_from->format('Y-m-d'),
            'date_to' => $date_to->format('Y-m-d'),
            'data' => $data,
        ]);
    }


    public function worker_report(Request $request)
    {
        $date_from = $request->date_from
        ? Carbon::parse($request->date_from)->startOfDay()
        : Carbon::now()->subDays(3)->startOfDay();

        $date_to = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        $allWorker = User::whereIn('role_id', [4, 5])->get();

        $data = [];

        $alldateBetween = [];
        $currentDate = $date_from->copy();

        while ($currentDate->lte($date_to)) {
            $alldateBetween[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        $data = [];

        foreach ($allWorker as $worker) {
            $daily_activities = DailyActivity::whereBetween('daily_activity_date', [$date_from, $date_to])
                ->where(function ($query) use ($worker) {
                    $query->where('leader_id', $worker->id)
                        ->orWhereRaw("JSON_CONTAINS(operator_ids, '\"{$worker->id}\"')");
                })
                ->get();

            $total_salary = WorkerSalary::whereBetween('daily_date', [$date_from, $date_to])->where('user_id', $worker->id)->sum('salary_amount');

            $data[] = [
                'worker_id' => $worker->id,
                'worker_name' => $worker->name,
                'role' => $worker->role->name,
                'total_activity' => $daily_activities->count(),
                'total_activity_items' => $daily_activities->sum(fn($a) => $a->items->count()),
                'total_salary' => $total_salary,
            ];
        }

        return view('report.worker_report', [
            'date_from' => $date_from->format('Y-m-d'),
            'date_to'   => $date_to->format('Y-m-d'),
            'data'      => $data,
        ]);
    }

    public function worker_daily_report(Request $request)
    {
        $data = [];

        if ($request->filled(['date_from', 'date_to', 'user_id'])) {

            $date_from = Carbon::parse($request->date_from)->startOfDay();
            $date_to = Carbon::parse($request->date_to)->endOfDay();
            $user_id = $request->user_id;

            $alldateBetween = [];
            $currentDate = $date_from->copy();
            while ($currentDate->lte($date_to)) {
                $alldateBetween[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            foreach ($alldateBetween as $date) {
                $daily_activities = DailyActivity::with('items')
                    ->whereDate('daily_activity_date', $date)
                    ->where(function ($query) use ($user_id) {
                        $query->where('leader_id', $user_id)
                            ->orWhereRaw("JSON_CONTAINS(operator_ids, ?)", ['"' . $user_id . '"']);
                    })
                    ->get();
                    
                $total_salary = WorkerSalary::where('daily_date', $date)->where('user_id', $user_id)->sum('salary_amount');

                $data[] = [
                    'date' => $date,
                    'worker_name' => User::find($user_id)->name ?? 'N/A',
                    'total_activity' => $daily_activities->count(),
                    'total_activity_items' => $daily_activities->sum(fn($a) => $a->items->count()),
                    'total_salary' => $total_salary,
                ];
            }
        }

        $allWorker = User::whereIn('role_id', [4, 5])->get();

        return view('report.worker_daily_report', [
            'allWorker' => $allWorker,
            'data' => $data,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'user_id' => $request->user_id,
        ]);
    }

    public function driver_daily_report(Request $request){
        $date = $request->date;
        $data = [];
        $drivers = User::where('role_id',6)->where('is_active',1)->get();
        foreach($drivers as $driver){
            $tools = Extra::whereDate('isseued_date', $date)->where('created_by_id',$driver->id)->sum('amount');
            $expenses = Expense::whereDate('isseued_date', $date)->where('created_by_id',$driver->id)->sum('amount');
            $total_customer = Customer::whereDate('created_at', $date)->where('user_id',$driver->id)->count();
            $daily_cleaning = DailyCleaning::whereDate('daily_cleaning_date', $date)->where('driver_id',$driver->id)->get();

            $total_cleaning = $daily_cleaning->count();
            $total_sales = $daily_cleaning->sum('sales');
            $total_sst = $daily_cleaning->sum('sst_amount');
            $total_profit = $daily_cleaning->sum('profit');

            // PUSH DATA
            $data[] = [
                'date'               => $date,
                'id'               => $driver->id??'',
                'driver'               => $driver->name??'',
                'total_customer'     => $total_customer,
                'total_cleaning'     => $total_cleaning,
                'total_sales'        => $total_sales,
                'total_sst'          => $total_sst,
                'total_profit'       => $total_profit,
                'total_cleaning_tool'=> $tools,     
                'total_expenses'     => $expenses,   
            ];
        }
        return view('report.driver_daily_report', [
            'data'      => $data,
        ]);

    }

    public function worker_kpi(Request $request)
    {
        // Handle dates
        $date_from = $request->date_from
            ? Carbon::parse($request->date_from)->startOfDay()
            : Carbon::now()->subDays(3)->startOfDay();

        $date_to = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        // Get all drivers
        $drivers = User::where('role_id', 6)->get();

        // Get all cleaners
        $cleaners = User::where('role_id', 7)->get();

        // Preload salaries for all users in date range
        $salaries = DcWorkerSalary::whereBetween('daily_date', [$date_from, $date_to])
            ->select('user_id', DB::raw('SUM(salary_amount) as total_salary'))
            ->groupBy('user_id')
            ->pluck('total_salary', 'user_id');

        // Preload cleaning summary for drivers
        $cleaningSummary = DailyCleaning::whereBetween('daily_cleaning_date', [$date_from, $date_to])
            ->select(
                'driver_id',
                DB::raw('COUNT(*) as total_cleaning'),
                DB::raw('SUM(sales) as total_sales')
            )
            ->groupBy('driver_id')
            ->get()
            ->keyBy('driver_id');

        // Attach summary and salary to drivers
        foreach ($drivers as $driver) {
            $driver->driver_salary = $salaries[$driver->id] ?? 0;
            $summary = $cleaningSummary[$driver->id] ?? null;
            $driver->total_cleaning = $summary->total_cleaning ?? 0;
            $driver->total_sales = $summary->total_sales ?? 0;
        }

        // Preload KPI summary for cleaners
        $kpiSummary = CleanerKpi::whereBetween('date', [$date_from, $date_to])
            ->select(
                'user_id',
                DB::raw('SUM(score) as total_score'),
                DB::raw('SUM(duration_hours) as total_duration_hours'),
                DB::raw('COUNT(*) as total_cleaning'),
                DB::raw('COUNT(DISTINCT date) as total_day_work')
            )
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Attach KPI and salary to cleaners
        foreach ($cleaners as $cleaner) {
            $summary = $kpiSummary[$cleaner->id] ?? null;
            $cleaner->cleaner_salary = $salaries[$cleaner->id] ?? 0;
            $cleaner->cleaner_score = round($summary->total_score ?? 0, 2);
            $cleaner->cleaner_duration = $summary->total_duration_hours ?? 0;
            $cleaner->total_cleaning = $summary->total_cleaning ?? 0;
            $cleaner->total_day_work = $summary->total_day_work ?? 0;
        }

        return view('report.worker_kpi', [
            'date_from' => $date_from->format('Y-m-d'),
            'date_to'   => $date_to->format('Y-m-d'),
            'drivers'   => $drivers,
            'cleaners'  => $cleaners,
        ]);
    }

    public function worker_kpi_report(Request $request)
    {
        $data = [];

        if ($request->filled(['date_from', 'date_to', 'user_id'])) {
            $date_from = Carbon::parse($request->date_from)->startOfDay();
            $date_to = Carbon::parse($request->date_to)->endOfDay();
            $user_id = $request->user_id;

            // Eager load related daily_cleaning and user to prevent N+1 queries
            $cleanerKPI = CleanerKpi::with(['daily_cleaning', 'user'])
                ->whereBetween('date', [$date_from, $date_to])
                ->where('user_id', $user_id)
                ->get();

            foreach ($cleanerKPI as $kpi) {
                $data[] = [
                    'daily_cleaning_no' => $kpi->daily_cleaning->daily_cleaning_no ?? '',
                    'date' => $kpi->date ?? '',
                    'worker_name' => $kpi->user->name ?? '',
                    'time_from' => $kpi->time_from,
                    'time_to' => $kpi->time_to,
                    'duration' => $kpi->duration_hours,
                    'no_of_worker' => $kpi->no_of_cleaner,
                    'score' => round($kpi->score,2),
                ];
            }
        }

        $allWorker = User::whereIn('role_id', [6, 7])->get();

        return view('report.worker_kpi_report', [
            'allWorker' => $allWorker,
            'data' => $data,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'user_id' => $request->user_id,
        ]);
    }



}
