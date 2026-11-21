<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Setting;
use Illuminate\Http\Request;

class FeeSettingController extends Controller
{
    public function edit()
    {
        return view('fee_setting.edit', [
            'daycareFee' => Setting::daycareFee(),
            'bathLunchFee' => Setting::bathLunchFee(),
            'schools' => School::orderBy('name')->get(['id', 'name', 'transport_fee']),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'daycare_fee' => ['required', 'numeric', 'min:0'],
            'bath_lunch_fee' => ['required', 'numeric', 'min:0'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('fee_setting.edit')->with('success', __('Fee settings saved.'));
    }
}
