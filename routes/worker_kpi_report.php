<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/worker_kpi_report')->as('worker_kpi_report.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ReportController@worker_kpi_report')->name('index');
});
