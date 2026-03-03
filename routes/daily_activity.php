<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/daily_activity')->as('daily_activity.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'DailyActivityController@index')->name('index');
    Route::get('/create', 'DailyActivityController@create')->name('create');
    Route::post('/store', 'DailyActivityController@store')->name('store');
    Route::post('/addActivityItem/{daily_activity}', 'DailyActivityController@addActivityItem')->name('addActivityItem');
    Route::get('/edit/{daily_activity}', 'DailyActivityController@edit')->name('edit');
    Route::post('/update/{daily_activity}', 'DailyActivityController@update')->name('update');
    Route::get('/destroy/{daily_activity}', 'DailyActivityController@destroy')->name('destroy');
    Route::post('/updateActivityItem/{daily_activity_item}', 'DailyActivityController@updateActivityItem')->name('updateActivityItem');
    Route::get('/destroyActivityItem/{daily_activity_item}', 'DailyActivityController@destroyActivityItem')->name('destroyActivityItem');
    Route::get('/duplicateActivityItem/{daily_activity_item}', 'DailyActivityController@duplicateActivityItem')->name('duplicateActivityItem');
    Route::get('/complete/{daily_activity}', 'DailyActivityController@complete')->name('complete');
});
