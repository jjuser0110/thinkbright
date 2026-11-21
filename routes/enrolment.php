<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::prefix('/daycare/enrolments')->as('enrolment.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'DaycareEnrolmentController@index')->name('index');
});
