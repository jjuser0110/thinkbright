<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\DailyCleaning;
use App\Models\CleanerKpi;
use App\Models\Customer;
use App\Models\User;
use Bouncer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RunningNumber;

class DailyCleaningController extends Controller
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
            $daily_cleaning = DailyCleaning::whereBetween('daily_cleaning_date', [$date_from, $date_to])->where('driver_id',Auth::id())->orderBy('created_at','DESC')->get();
        }else {      
            $daily_cleaning = DailyCleaning::whereBetween('daily_cleaning_date', [$date_from, $date_to])->orderBy('created_at','DESC')->get();
        }

        $date_from = $date_from->format('Y-m-d');
        $date_to   = $date_to->format('Y-m-d');
        return view('daily_cleaning.index')->with('daily_cleaning',$daily_cleaning)->with('date_from',$date_from)->with('date_to',$date_to);
    }

    public function create()
    {
        $driverQuery = User::where('role_id', 6);

        $cleaners = User::where('role_id',7)->where('is_active',1)->get();

        if (Auth::user()->role_id == 6) {
            $driverQuery->where('id', Auth::id());
        }

        $drivers = $driverQuery->get();

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $check = RunningNumber::where('name', 'daily_cleaning')
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if (!$check) {
            $check = RunningNumber::create([
                'code' => 'DC',
                'name' => 'daily_cleaning',
                'year' => $year,
                'month' => $month,
                'no_of_digit_behind' => 4,
                'running_no' => 1,
            ]);
        }

        $daily_cleaning_no = $check->code .
            $check->year .
            sprintf('%02d', $check->month) .
            sprintf('%0' . $check->no_of_digit_behind . 'd', $check->running_no);

        $customer = Customer::all();

        return view('daily_cleaning.create', [
            'drivers' => $drivers,
            'cleaners' => $cleaners,
            'daily_cleaning_no' => $daily_cleaning_no,
            'code' => $check->code,
            'year' => $check->year,
            'month' => $check->month,
            'customer' => $customer,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $profit = round($request->sales / 1.08,2);
        $sst_amount = $request->sales - $profit;
        $request->merge([
            'profit'=>$profit,
            'sst_amount'=>$sst_amount,
        ]);
        $daily_cleaning = DailyCleaning::create($request->all());
        $check = RunningNumber::where('code', $request->code)
            ->where('year', $request->year)
            ->where('month', $request->month)
            ->first();
        $check->increment('running_no');

        $customer = Customer::where('customer_name',$daily_cleaning->customer_name)->first();
        if(!$customer){
            Customer::create([
                'customer_name'=>$daily_cleaning->customer_name,
                'address'=>$daily_cleaning->address,
                'customer_contact'=>$daily_cleaning->customer_contact,
                'user_id'=>$daily_cleaning->driver_id,
            ]);
        }

        $per_user_per_hour_rate = 0.25;
        $duration_hours = Carbon::parse($daily_cleaning->end_time)
            ->diffInMinutes(Carbon::parse($daily_cleaning->start_time)) / 60;

        $duration_hours = round($duration_hours);
        $daily_cleaning->update(['duration_hours'=>$duration_hours]);

        $score = $duration_hours * $per_user_per_hour_rate / count($request->cleaner_ids);

        foreach ($request->cleaner_ids as $cleaner_id) {
            $cleanerKpi = CleanerKpi::create([
                'daily_cleaning_id' => $daily_cleaning->id,
                'user_id' => $cleaner_id,
                'date' => $daily_cleaning->daily_cleaning_date,
                'time_from' => $daily_cleaning->start_time,
                'time_to' => $daily_cleaning->end_time,
                'duration_hours' => $duration_hours,
                'no_of_cleaner' => count($request->cleaner_ids),
                'score' => $score,
            ]);
        }


        return redirect()->route('daily_cleaning.index',$daily_cleaning)->withSuccess('Data saved');
    }

    public function edit(DailyCleaning $daily_cleaning)
    {
        $driverQuery = User::where('role_id', 6);

        $cleaners = User::where('role_id',7)->where('is_active',1)->get();

        if (Auth::user()->role_id == 6) {
            $driverQuery->where('id', Auth::id());
        }

        $customer = Customer::all();
        $drivers = $driverQuery->get();
        return view('daily_cleaning.create', [
            'drivers' => $drivers,
            'cleaners' => $cleaners,
            'customer' => $customer,
            'daily_cleaning' => $daily_cleaning,
        ]);
    }

    public function update(Request $request, DailyCleaning $daily_cleaning)
    {
        $profit = round($request->sales / 1.08,2);
        $sst_amount = $request->sales - $profit;
        $request->merge([
            'profit'=>$profit,
            'sst_amount'=>$sst_amount,
            'checked'=>0,
        ]);
        
        $daily_cleaning->update($request->all());
        $customer = Customer::where('customer_name',$daily_cleaning->customer_name)->first();
        if($customer){
            $customer->update([
                'address'=>$daily_cleaning->address,
                'customer_contact'=>$daily_cleaning->customer_contact,
            ]);
        }
        $otherKpis = CleanerKpi::where('daily_cleaning_id',$daily_cleaning->id)->get();
        foreach($otherKpis as $kpi){
            $kpi->delete();
        }

        $per_user_per_hour_rate = 0.25;
        $duration_hours = Carbon::parse($daily_cleaning->end_time)
            ->diffInMinutes(Carbon::parse($daily_cleaning->start_time)) / 60;

        $duration_hours = round($duration_hours);
        $daily_cleaning->update(['duration_hours'=>$duration_hours]);

        $score = $duration_hours * $per_user_per_hour_rate / count($request->cleaner_ids);

        foreach ($request->cleaner_ids as $cleaner_id) {
            $cleanerKpi = CleanerKpi::create([
                'daily_cleaning_id' => $daily_cleaning->id,
                'user_id' => $cleaner_id,
                'date' => $daily_cleaning->daily_cleaning_date,
                'time_from' => $daily_cleaning->start_time,
                'time_to' => $daily_cleaning->end_time,
                'duration_hours' => $duration_hours,
                'no_of_cleaner' => count($request->cleaner_ids),
                'score' => $score,
            ]);
        }

        return redirect()->route('daily_cleaning.index')->withSuccess('Data updated');
    }

    public function destroy(DailyCleaning $daily_cleaning)
    {
        $daily_cleaning->delete();

        return redirect()->route('daily_cleaning.index')->withSuccess('Data deleted');
    }

}
