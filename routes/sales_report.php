<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/sales_report')->as('sales_report.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ReportController@sales_report')->name('index');
});
