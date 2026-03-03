<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/daily_cleaning_closing')->as('daily_cleaning_closing.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'DailyCleaningClosingController@index')->name('index');
    Route::get('/create', 'DailyCleaningClosingController@create')->name('create');
    Route::post('/store', 'DailyCleaningClosingController@store')->name('store');
    Route::get('/edit/{daily_cleaning_closing}', 'DailyCleaningClosingController@edit')->name('edit');
    Route::post('/update/{daily_cleaning_closing}', 'DailyCleaningClosingController@update')->name('update');
    Route::get('/destroy/{daily_cleaning_closing}', 'DailyCleaningClosingController@destroy')->name('destroy');
});
