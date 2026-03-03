<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/expense')->as('expense.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ExpenseController@index')->name('index');
    Route::get('/create', 'ExpenseController@create')->name('create');
    Route::post('/store', 'ExpenseController@store')->name('store');
    Route::get('/edit/{expense}', 'ExpenseController@edit')->name('edit');
    Route::post('/update/{expense}', 'ExpenseController@update')->name('update');
    Route::get('/destroy/{expense}', 'ExpenseController@destroy')->name('destroy');
});
