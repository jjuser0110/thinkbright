<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/bank-account')->as('bank_account.')->middleware('auth')->group(function() {
    Route::get('/index', 'BankAccountController@index')->name('index');
    Route::get('/create', 'BankAccountController@create')->name('create');
    Route::post('/store', 'BankAccountController@store')->name('store');
    Route::get('/edit/{bankAccount}', 'BankAccountController@edit')->name('edit');
    Route::post('/update/{bankAccount}', 'BankAccountController@update')->name('update');
    Route::get('/destroy/{bankAccount}', 'BankAccountController@destroy')->name('destroy');

    Route::get('/recalculate/{bankAccount}', 'TransactionController@recalculate')->name('recalculate');
    Route::get('/transaction-list/{bankAccount}', 'TransactionController@index')->name('transaction');
    Route::prefix('/transaction')->as('transaction.')->middleware('auth')->group(function() {
        Route::post('/deposit', 'TransactionController@deposit')->name('deposit');
        Route::post('/withdraw', 'TransactionController@withdraw')->name('withdraw');
        Route::post('/update', 'TransactionController@update')->name('update');
        Route::get('/destroy/{transaction}', 'TransactionController@destroy')->name('destroy');
    });
});
