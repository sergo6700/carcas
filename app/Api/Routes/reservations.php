<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/reservations/list', \Api\Http\Controllers\ReservationsController::class . '@listable')->name('api.reservations.listable');
    Route::get('/reservations/paginated', \Api\Http\Controllers\ReservationsController::class . '@paginated')->name('api.reservations.paginated');
    Route::get('/reservations/single/{id}', \Api\Http\Controllers\ReservationsController::class . '@single')->name('api.reservations.single');
    Route::post('/reservations/create', \Api\Http\Controllers\ReservationsController::class . '@create')->name('api.reservations.create');
    Route::put('/reservations/update/{id}', \Api\Http\Controllers\ReservationsController::class . '@update')->name('api.reservations.update');
    Route::delete('/reservations/delete/{id}', \Api\Http\Controllers\ReservationsController::class . '@delete')->name('api.reservations.delete');
});
