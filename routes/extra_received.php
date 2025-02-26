<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/extra_received')->as('extra_received.')->middleware('auth')->group(function() {
    Route::get('/index', 'ExtraReceivedController@index')->name('index');
    Route::get('/create', 'ExtraReceivedController@create')->name('create');
    Route::post('/store', 'ExtraReceivedController@store')->name('store');
    Route::get('/edit/{extra_received}', 'ExtraReceivedController@edit')->name('edit');
    Route::post('/update/{extra_received}', 'ExtraReceivedController@update')->name('update');
    Route::get('/destroy/{extra_received}', 'ExtraReceivedController@destroy')->name('destroy');
});
