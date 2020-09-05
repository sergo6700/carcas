<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/rate-calendar/detailed', \Api\Http\Controllers\RateCalendarController::class . '@detailed')->name('api.rate-calendar.detailed');
    Route::get('/rate-calendar/compressed', \Api\Http\Controllers\RateCalendarController::class . '@compressed')->name('api.rate-calendar.compressed');
    Route::get('/rate-calendar/{id}/children', \Api\Http\Controllers\RateCalendarController::class . '@children')->name('api.rate-calendar.children');
    Route::post('/rate-calendar/create', \Api\Http\Controllers\RateCalendarController::class . '@create')->name('api.rate-calendar.create');
});
