<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/leader')->as('leader.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'LeaderController@index')->name('index');
    Route::get('/create', 'LeaderController@create')->name('create');
    Route::post('/store', 'LeaderController@store')->name('store');
    Route::get('/edit/{leader}', 'LeaderController@edit')->name('edit');
    Route::post('/update/{leader}', 'LeaderController@update')->name('update');
    Route::get('/destroy/{leader}', 'LeaderController@destroy')->name('destroy');
});
