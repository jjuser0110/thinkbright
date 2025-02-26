<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/receipt')->as('receipt.')->middleware('auth')->group(function() {
    Route::get('/index', 'ReceiptController@index')->name('index');
    Route::get('/create', 'ReceiptController@create')->name('create');
    Route::post('/store', 'ReceiptController@store')->name('store');
    Route::get('/edit/{receipt}', 'ReceiptController@edit')->name('edit');
    Route::post('/update/{receipt}', 'ReceiptController@update')->name('update');
    Route::get('/destroy/{receipt}', 'ReceiptController@destroy')->name('destroy');
    Route::post('/pdfDetails', 'ReceiptController@pdfDetails')->name('pdfDetails');
});
