<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', \Api\Http\Controllers\UsersController::class . '@auth')->name('api.user');
    Route::get('/users/list', \Api\Http\Controllers\UsersController::class . '@listable')->name('api.users.listable');
});
