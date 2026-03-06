<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/public_holiday')->as('public_holiday.')->middleware('auth')->group(function() {
    Route::get('/index', 'PublicHolidayController@index')->name('index');
    Route::get('/create', 'PublicHolidayController@create')->name('create');
    Route::post('/store', 'PublicHolidayController@store')->name('store');
    Route::get('/edit/{public_holiday}', 'PublicHolidayController@edit')->name('edit');
    Route::post('/update/{public_holiday}', 'PublicHolidayController@update')->name('update');
    Route::get('/destroy/{public_holiday}', 'PublicHolidayController@destroy')->name('destroy');
});
