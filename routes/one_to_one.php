<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/my-classes', 'MyClassController@index')->middleware('auth')->name('my_classes.index');

Route::prefix('/one-to-one')->as('one_to_one.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'OneToOneClassController@index')->name('index');
    Route::get('/create', 'OneToOneClassController@create')->name('create');
    Route::post('/', 'OneToOneClassController@store')->name('store');
    Route::get('/{one_to_one}/edit', 'OneToOneClassController@edit')->name('edit');
    Route::put('/{one_to_one}', 'OneToOneClassController@update')->name('update');
    Route::delete('/{one_to_one}', 'OneToOneClassController@destroy')->name('destroy');
});
