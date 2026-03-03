<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/daily_report')->as('daily_report.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ReportController@daily_report')->name('index');
});
