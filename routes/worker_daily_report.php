<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/worker_daily_report')->as('worker_daily_report.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ReportController@worker_daily_report')->name('index');
});
