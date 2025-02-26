<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/food')->as('food.')->middleware('auth')->group(function() {
    Route::get('/index', 'FoodController@index')->name('index');
    Route::get('/create', 'FoodController@create')->name('create');
    Route::post('/store', 'FoodController@store')->name('store');
    Route::get('/edit/{food}', 'FoodController@edit')->name('edit');
    Route::post('/update/{food}', 'FoodController@update')->name('update');
    Route::get('/destroy/{food}', 'FoodController@destroy')->name('destroy');
});
