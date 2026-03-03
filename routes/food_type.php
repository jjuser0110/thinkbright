<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/food_type')->as('food_type.')->middleware('auth')->group(function() {
    Route::get('/index', 'FoodTypeController@index')->name('index');
    Route::get('/create', 'FoodTypeController@create')->name('create');
    Route::post('/store', 'FoodTypeController@store')->name('store');
    Route::get('/edit/{food_type}', 'FoodTypeController@edit')->name('edit');
    Route::post('/update/{food_type}', 'FoodTypeController@update')->name('update');
    Route::get('/destroy/{food_type}', 'FoodTypeController@destroy')->name('destroy');
});
