<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::prefix('/fee-setting')->as('fee_setting.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'FeeSettingController@edit')->name('edit');
    Route::post('/', 'FeeSettingController@update')->name('update');
});
