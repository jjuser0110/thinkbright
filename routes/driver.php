<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/driver')->as('driver.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'DriverController@index')->name('index');
    Route::get('/create', 'DriverController@create')->name('create');
    Route::post('/store', 'DriverController@store')->name('store');
    Route::get('/edit/{driver}', 'DriverController@edit')->name('edit');
    Route::post('/update/{driver}', 'DriverController@update')->name('update');
    Route::get('/destroy/{driver}', 'DriverController@destroy')->name('destroy');
});
