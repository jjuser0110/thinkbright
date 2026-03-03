<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/holiday')->as('holiday.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'HolidayController@index')->name('index');
    Route::get('/create', 'HolidayController@create')->name('create');
    Route::post('/store', 'HolidayController@store')->name('store');
    Route::get('/edit/{holiday}', 'HolidayController@edit')->name('edit');
    Route::post('/update/{holiday}', 'HolidayController@update')->name('update');
    Route::get('/destroy/{holiday}', 'HolidayController@destroy')->name('destroy');
});
