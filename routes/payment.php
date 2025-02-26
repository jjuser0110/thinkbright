<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/payment')->as('payment.')->middleware('auth')->group(function() {
    Route::get('/index', 'PaymentController@index')->name('index');
    Route::get('/create', 'PaymentController@create')->name('create');
    Route::post('/store', 'PaymentController@store')->name('store');
    Route::get('/edit/{payment}', 'PaymentController@edit')->name('edit');
    Route::post('/update/{payment}', 'PaymentController@update')->name('update');
    Route::get('/destroy/{payment}', 'PaymentController@destroy')->name('destroy');
});
