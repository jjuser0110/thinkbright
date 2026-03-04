<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/salary')->as('salary.')->middleware('auth')->group(function() {
    Route::get('/index', 'SalaryController@index')->name('index');
    Route::get('/create', 'SalaryController@create')->name('create');
    Route::post('/store', 'SalaryController@store')->name('store');
    Route::get('/edit/{salary}', 'SalaryController@edit')->name('edit');
    Route::post('/update/{salary}', 'SalaryController@update')->name('update');
    Route::get('/destroy/{salary}', 'SalaryController@destroy')->name('destroy');
    Route::post('/pdfDetails', 'SalaryController@pdfDetails')->name('pdfDetails');
});
