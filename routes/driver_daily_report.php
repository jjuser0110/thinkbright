<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/driver_daily_report')->as('driver_daily_report.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ReportController@driver_daily_report')->name('index');
});
