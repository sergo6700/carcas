<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/data/iso-countries-2-letters', \Api\Http\Controllers\DataController::class . '@isoCountries2Letter')->name('api.data.iso-countries-2-letters');
    Route::get('/data/iso-countries-3-letters', \Api\Http\Controllers\DataController::class . '@isoCountries3Letter')->name('api.data.iso-countries-3-letters');
    Route::get('/data/stat-types', \Api\Http\Controllers\DataController::class . '@statTypes')->name('api.data.stat-types');
    Route::get('/data/police-types', \Api\Http\Controllers\DataController::class . '@policeTypes')->name('api.data.police-types');
    Route::get('/data/tax-types', \Api\Http\Controllers\DataController::class . '@taxTypes')->name('api.data.tax-types');
    Route::get('/data/price-types', \Api\Http\Controllers\DataController::class . '@priceTypes')->name('api.data.price-types');
    Route::get('/data/versions', \Api\Http\Controllers\DataController::class . '@versions')->name('api.data.versions');
    Route::get('/data/currencies', \Api\Http\Controllers\DataController::class . '@currencies')->name('api.data.currencies');
    Route::get('/data/accommodations', \Api\Http\Controllers\DataController::class . '@accommodations')->name('api.data.accommodations');
    Route::get('/data/reservation-statuses', \Api\Http\Controllers\DataController::class . '@reservationStatuses')->name('api.data.reservation-statuses');
    Route::get('/data/reservation-date-types', \Api\Http\Controllers\DataController::class . '@reservationDateTypes')->name('api.data.reservation-date-types');
    Route::get('/data/rate-calendar-types', \Api\Http\Controllers\DataController::class . '@rateCalendarTypes')->name('api.data.rate-calendar-types');
    Route::get('/data/locale', \Api\Http\Controllers\DataController::class . '@locale')->name('api.data.locale');
});
