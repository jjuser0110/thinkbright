<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/account_month')->as('account_month.')->middleware('auth')->group(function() {
    Route::get('/index', 'AccountMonthController@index')->name('index');
    Route::get('/create', 'AccountMonthController@create')->name('create');
    Route::post('/store', 'AccountMonthController@store')->name('store');
    Route::get('/sync/{account_month}', 'AccountMonthController@sync')->name('sync');
    Route::get('/edit/{account_month}', 'AccountMonthController@edit')->name('edit');
    Route::get('/update/{table_name}/{table_value}', 'AccountMonthController@update')->name('update');
    Route::get('/destroy/{account_month}', 'AccountMonthController@destroy')->name('destroy');
    Route::get('/destroy_specific_acc/{account}', 'AccountMonthController@destroy_specific_acc')->name('destroy_specific_acc');
});
