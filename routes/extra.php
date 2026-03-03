<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/extra')->as('extra.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ExtraController@index')->name('index');
    Route::get('/create', 'ExtraController@create')->name('create');
    Route::post('/store', 'ExtraController@store')->name('store');
    Route::get('/edit/{extra}', 'ExtraController@edit')->name('edit');
    Route::post('/update/{extra}', 'ExtraController@update')->name('update');
    Route::get('/destroy/{extra}', 'ExtraController@destroy')->name('destroy');
});
