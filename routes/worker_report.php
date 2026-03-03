<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/worker_report')->as('worker_report.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ReportController@worker_report')->name('index');
});
