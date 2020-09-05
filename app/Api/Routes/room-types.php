<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/room-types/list', \Api\Http\Controllers\RoomTypesController::class . '@listable')->name('api.room-types.listable');
    Route::get('/room-types/collected', \Api\Http\Controllers\RoomTypesController::class . '@collected')->name('api.room-types.collected');
    Route::get('/room-types/single/{id}', \Api\Http\Controllers\RoomTypesController::class . '@single')->name('api.room-types.single');
});
