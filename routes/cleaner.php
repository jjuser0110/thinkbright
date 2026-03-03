<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/cleaner')->as('cleaner.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'CleanerController@index')->name('index');
    Route::get('/create', 'CleanerController@create')->name('create');
    Route::post('/store', 'CleanerController@store')->name('store');
    Route::get('/edit/{cleaner}', 'CleanerController@edit')->name('edit');
    Route::post('/update/{cleaner}', 'CleanerController@update')->name('update');
    Route::get('/destroy/{cleaner}', 'CleanerController@destroy')->name('destroy');
});
