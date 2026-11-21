<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

// Teacher: my leave
Route::prefix('/my-leave')->as('my_leave.')->middleware('auth')->group(function () {
    Route::get('/', 'MyLeaveController@index')->name('index');
    Route::post('/', 'MyLeaveController@store')->name('store');
    Route::post('/{leave}/cancel', 'MyLeaveController@cancel')->name('cancel');
});

// Admin: approve / reject
Route::prefix('/leave')->as('leave.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'LeaveApplicationController@index')->name('index');
    Route::post('/{leave}/approve', 'LeaveApplicationController@approve')->name('approve');
    Route::post('/{leave}/reject', 'LeaveApplicationController@reject')->name('reject');
});
