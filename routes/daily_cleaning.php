<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/daily_cleaning')->as('daily_cleaning.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'DailyCleaningController@index')->name('index');
    Route::get('/create', 'DailyCleaningController@create')->name('create');
    Route::post('/store', 'DailyCleaningController@store')->name('store');
    Route::get('/edit/{daily_cleaning}', 'DailyCleaningController@edit')->name('edit');
    Route::post('/update/{daily_cleaning}', 'DailyCleaningController@update')->name('update');
    Route::get('/destroy/{daily_cleaning}', 'DailyCleaningController@destroy')->name('destroy');
});
