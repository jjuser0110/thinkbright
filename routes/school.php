<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/school')->as('school.')->middleware('auth')->group(function() {
    Route::get('/index', 'SchoolController@index')->name('index');
    Route::get('/create', 'SchoolController@create')->name('create');
    Route::post('/store', 'SchoolController@store')->name('store');
    Route::get('/edit/{school}', 'SchoolController@edit')->name('edit');
    Route::post('/update/{school}', 'SchoolController@update')->name('update');
    Route::get('/destroy/{school}', 'SchoolController@destroy')->name('destroy');
});
