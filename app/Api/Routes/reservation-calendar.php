<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/reservation-calendar/data', \Api\Http\Controllers\ReservationCalendarController::class . '@data')->name('api.reservation-calendar.data');
});
