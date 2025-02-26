<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/student')->as('student.')->middleware('auth')->group(function() {
    Route::get('/index', 'StudentController@index')->name('index');
    Route::get('/create', 'StudentController@create')->name('create');
    Route::post('/store', 'StudentController@store')->name('store');
    Route::get('/edit/{student}', 'StudentController@edit')->name('edit');
    Route::post('/update/{student}', 'StudentController@update')->name('update');
    Route::get('/destroy/{student}', 'StudentController@destroy')->name('destroy');
});
