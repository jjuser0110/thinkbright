<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/kod')->as('kod.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'KodController@index')->name('index');
    Route::get('/create', 'KodController@create')->name('create');
    Route::post('/store', 'KodController@store')->name('store');
    Route::get('/edit/{kod}', 'KodController@edit')->name('edit');
    Route::post('/update/{kod}', 'KodController@update')->name('update');
    Route::get('/destroy/{kod}', 'KodController@destroy')->name('destroy');
});
