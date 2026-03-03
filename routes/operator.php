<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/operator')->as('operator.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'OperatorController@index')->name('index');
    Route::get('/create', 'OperatorController@create')->name('create');
    Route::post('/store', 'OperatorController@store')->name('store');
    Route::get('/edit/{operator}', 'OperatorController@edit')->name('edit');
    Route::post('/update/{operator}', 'OperatorController@update')->name('update');
    Route::get('/destroy/{operator}', 'OperatorController@destroy')->name('destroy');
});
