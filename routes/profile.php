<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

// Pages every logged-in user (admin or teacher) can use.
Route::middleware('auth')->group(function () {
    Route::get('/profile', 'ProfileController@edit')->name('profile.edit');
    Route::post('/profile', 'ProfileController@update')->name('profile.update');

    Route::get('/user/change_password', 'UserController@change_password')->name('user.change_password');
    Route::post('/user/changePassword', 'UserController@changePassword')->name('user.changePassword');

    Route::get('/notifications', 'NotificationController@index')->name('notifications.index');
    Route::get('/notifications/{id}/open', 'NotificationController@open')->name('notifications.open');
    Route::post('/notifications/read-all', 'NotificationController@readAll')->name('notifications.read_all');
});

Route::get('/locale/{locale}', 'LocaleController@switch')->name('locale.switch');
