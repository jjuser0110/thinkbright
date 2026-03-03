<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/worker_kpi')->as('worker_kpi.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ReportController@worker_kpi')->name('index');
});
