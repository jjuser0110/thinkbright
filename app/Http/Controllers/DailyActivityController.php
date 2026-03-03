<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\DailyActivity;
use App\Models\DailyActivityItem;
use App\Models\User;
use App\Models\Holiday;
use App\Models\KodKerja;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RunningNumber;
use App\Models\WorkerSalary;

class DailyActivityController extends Controller
{
    public function index(Request $request)
    {
        $date_from = $request->date_from
            ? Carbon::parse($request->date_from)->startOfDay()
            : Carbon::now()->subDays(3)->startOfDay();

        $date_to = $request->date_to
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        // Base query
        $daily_activity = DailyActivity::whereBetween('daily_activity_date', [$date_from, $date_to]);

        // If role 4: filter by leader
        if (Auth::user()->role_id == 4) {
            $daily_activity->where('leader_id', Auth::id());
        }

        // If line filtered
        if ($request->filled('line')) {
            $daily_activity->where('line', $request->line);
        }

        // Get results
        $daily_activity = $daily_activity->orderBy('created_at', 'DESC')->get();

        $line = User::where('role_id', 4)->where('is_active', 1)->get();

        return view('daily_activity.index', [
            'daily_activity' => $daily_activity,
            'date_from'      => $date_from->format('Y-m-d'),
            'date_to'        => $date_to->format('Y-m-d'),
            'line'           => $line
        ]);
    }

    public function create()
    {
        $leaderQuery = User::where('role_id', 4);

        $operatorQuery = User::whereIn('role_id', [4, 5]);

        if (Auth::user()->role_id == 4) {
            $leaderQuery->where('id', Auth::id());
            $operatorQuery->where('id', '!=', Auth::id());
        }

        $leader = $leaderQuery->where('is_active',1)->get();
        $operator = $operatorQuery->where('is_active',1)->get();

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $check = RunningNumber::where('name', 'daily_activity')
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if (!$check) {
            $check = RunningNumber::create([
                'code' => 'DA',
                'name' => 'daily_activity',
                'year' => $year,
                'month' => $month,
                'no_of_digit_behind' => 4,
                'running_no' => 1,
            ]);
        }

        $daily_activity_no = $check->code .
            $check->year .
            sprintf('%02d', $check->month) .
            sprintf('%0' . $check->no_of_digit_behind . 'd', $check->running_no);

        return view('daily_activity.create', [
            'leader' => $leader,
            'operator' => $operator,
            'daily_activity_no' => $daily_activity_no,
            'code' => $check->code,
            'year' => $check->year,
            'month' => $check->month,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->merge([
            'number_of_worker' => count($request->operator_ids)+1,
        ]);
        $daily_activity = DailyActivity::create($request->all());
        $check = RunningNumber::where('code', $request->code)
            ->where('year', $request->year)
            ->where('month', $request->month)
            ->first();
        $check->increment('running_no');

        return redirect()->route('daily_activity.edit',$daily_activity)->withSuccess('Data saved');
    }

    public function edit(DailyActivity $daily_activity)
    {
        $leaderQuery = User::where('role_id', 4);

        $operatorQuery = User::whereIn('role_id', [4, 5]);

        if (Auth::user()->role_id == 4) {
            $leaderQuery->where('id', Auth::id());
            $operatorQuery->where('id', '!=', Auth::id());
        }

        $leader = $leaderQuery->get();
        $operator = $operatorQuery->get();
        $kod = KodKerja::where('is_active', 1)->get();
        return view('daily_activity.create', [
            'leader' => $leader,
            'operator' => $operator,
            'daily_activity' => $daily_activity,
            'kod' => $kod,
        ]);
    }

    public function update(Request $request, DailyActivity $daily_activity)
    {
        $daily_activity->update($request->all());
        return redirect()->route('daily_activity.index')->withSuccess('Data updated');
    }

    public function destroy(DailyActivity $daily_activity)
    {
        $daily_activity->items()->delete();
        $daily_activity->salaries()->delete();

        $daily_activity->delete();

        return redirect()->route('daily_activity.index')->withSuccess('Data deleted successfully');
    }


    public function complete(DailyActivity $daily_activity)
    {
        $leader = $daily_activity->leader;
        $operators = User::whereIn('id', $daily_activity->operator_ids)->get();

        // Preload common data
        $isHoliday = Holiday::whereDate('date', $daily_activity->daily_activity_date)->exists();
        $itemsAfter5 = DailyActivityItem::where('daily_activity_id', $daily_activity->id)
            ->where('start_time', '>=', '17:00:00')
            ->get();

        $ot_cost = round(
            DailyActivityItem::where('daily_activity_id', $daily_activity->id)
                ->where('shift_type', 'ot')
                ->sum('grand_cost') / $daily_activity->number_of_worker,
            2
        );

        $normal_cost = round(
            DailyActivityItem::where('daily_activity_id', $daily_activity->id)
                ->where('shift_type', 'normal')
                ->sum('grand_cost') / $daily_activity->number_of_worker,
            2
        );

        // Helper closure for overtime calculation
        $calculateOvertime = function ($baseSalary) use ($itemsAfter5, $isHoliday) {
            if ($itemsAfter5->isEmpty()) {
                return 0;
            }

            $latestEnd = $itemsAfter5->max('end_time');
            $start = Carbon::parse('17:00:00');
            $end = Carbon::parse($latestEnd);
            $hours = $end->greaterThan($start) ? $end->diffInMinutes($start) / 60 : 0; 
            $hours = floor($hours);

            $rate = $isHoliday ? 2 : 1.5;
            return round(($baseSalary / 8) * $rate * $hours, 2);
        };

        // Combine leader + operators
        $users = collect([$leader])->merge($operators);

        foreach ($users as $user) {
            $hasFixedSalary = $user->salary_per_day > 0;

            if ($hasFixedSalary) {
                $salary = $isHoliday
                    ? round($user->salary_per_day * 2, 2)
                    : $user->salary_per_day;

                $ot = $calculateOvertime($user->salary_per_day);
                WorkerSalary::updateOrCreate(
                    [
                        'daily_activity_id' => $daily_activity->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'salary_type' => 'fulltime',
                        'salary_amount' => round($salary + $ot, 2),
                        'normal' => $salary,
                        'overtime' => $ot,
                        'daily_date' => $daily_activity->daily_activity_date,
                    ]
                );
            } else {
                WorkerSalary::updateOrCreate(
                    [
                        'daily_activity_id' => $daily_activity->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'salary_type' => 'operation',
                        'salary_amount' => round($daily_activity->expenses_total_per_pax,2),
                        'normal' => $normal_cost,
                        'overtime' => $ot_cost,
                        'daily_date' => $daily_activity->daily_activity_date,
                    ]
                );
            }
        }

        $salary = round($daily_activity->salaries->sum('salary_amount'),2);
        $profit = round($daily_activity->sales_total - $salary,2);
        $daily_activity->update(['status' => 'completed','salary' => $salary,'profit' => $profit]);

        return redirect()->back()->withSuccess('Data updated');
    }



    public function addActivityItem(Request $request, DailyActivity $daily_activity)
    {
        $rate = 1;
        $shift_type = 'normal';


        if ($request->start_time >= '19:00') {
            $rate = 1.5;
            $shift_type = 'ot';
        }

        $checkHoliday = Holiday::whereDate('date', $daily_activity->daily_activity_date)->first();
        if ($checkHoliday) {
            $rate = 2;
            $shift_type = 'ph';
        }

        $kod = KodKerja::find($request->kod_kerja_id);

        $cost = ($kod->worker_amount ?? 0) * $rate;
        $grand_cost = round($cost * $request->quantity, 4);

        $price = ($kod->boss_amount ?? 0) * $rate;
        $grand_price = round($price * $request->quantity, 4);

        $profit = round($grand_price - $grand_cost, 4);

        $request->merge([
            'daily_activity_id' => $daily_activity->id,
            'cost' => $cost,
            'grand_cost' => $grand_cost,
            'price' => $price,
            'grand_price' => $grand_price,
            'profit' => $profit,
            'shift_type' => $shift_type,
        ]);

        DailyActivityItem::create($request->all());
        $this->updateDaily($daily_activity);

        return redirect()->back()->withSuccess('Data created');
    }


    public function updateActivityItem(Request $request, DailyActivityItem $daily_activity_item)
    {
        $daily_activity = $daily_activity_item->daily_activity;
        $rate = 1;
        $shift_type = 'normal';

        if ($request->start_time >= '19:00') {
            $rate = 1.5;
            $shift_type = 'ot';
        }
        
        $checkHoliday = Holiday::whereDate('date', $daily_activity->daily_activity_date)->first();
        if ($checkHoliday) {
            $rate = 2;
            $shift_type = 'ph';
        }

        $kod = KodKerja::find($request->kod_kerja_id);

        $cost = ($kod->worker_amount ?? 0) * $rate;
        $grand_cost = round($cost * $request->quantity, 4);

        $price = ($kod->boss_amount ?? 0) * $rate;
        $grand_price = round($price * $request->quantity, 4);

        $profit = round($grand_price - $grand_cost, 4);

        $request->merge([
            'cost' => $cost,
            'grand_cost' => $grand_cost,
            'price' => $price,
            'grand_price' => $grand_price,
            'profit' => $profit,
            'shift_type' => $shift_type,
        ]);
        // dd($request->all());
        $daily_activity_item->update($request->all());
        $this->updateDaily($daily_activity);
        return redirect()->back()->withSuccess('Data updated');
    }

    public function destroyActivityItem(Request $request, DailyActivityItem $daily_activity_item)
    {
        $daily_activity = $daily_activity_item->daily_activity;
        $daily_activity_item->delete();
        $this->updateDaily($daily_activity);
        return redirect()->back()->withSuccess('Data updated');
    }

    public function duplicateActivityItem(Request $request, DailyActivityItem $daily_activity_item)
    {
        $daily_activity = $daily_activity_item->daily_activity;
        DailyActivityItem::create($daily_activity_item->toArray());
        $this->updateDaily($daily_activity);
        return redirect()->back()->withSuccess('Data updated');
    }

    public function updateDaily(DailyActivity $daily_activity)
    {
        $items = $daily_activity->items;
        $sales_total = $items->sum('grand_price');
        $expenses_total = $items->sum('grand_cost');
        $number_of_worker = $daily_activity->number_of_worker ?? 1;
        $expenses_total_per_pax = round($expenses_total / $number_of_worker,4);
        $profit = round($sales_total - $expenses_total,4);
        $daily_activity->update([
            'sales_total'=>$sales_total,
            'expenses_total'=>$expenses_total,
            'expenses_total_per_pax'=>$expenses_total_per_pax,
            'profit'=>$profit,
        ]);
    }

    public function countallsalary(){
        $daily = DailyActivity::all();
        foreach($daily as $daily_activity){
            $this->complete($daily_activity);
        }
        return "DONE";
    }
    

}
