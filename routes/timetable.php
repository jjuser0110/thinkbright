<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/daycare/timetable/view', 'DaycareTimetableController@view')->middleware('auth')->name('timetable.view');

Route::prefix('/daycare/timetable')->as('timetable.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'DaycareTimetableController@index')->name('index');
    Route::get('/create', 'DaycareTimetableController@create')->name('create');
    Route::post('/', 'DaycareTimetableController@store')->name('store');
    Route::get('/{timetable}/edit', 'DaycareTimetableController@edit')->name('edit');
    Route::put('/{timetable}', 'DaycareTimetableController@update')->name('update');
    Route::delete('/{timetable}', 'DaycareTimetableController@destroy')->name('destroy');
});
