<?php

Route::post('/session', \Api\Http\Controllers\Auth\LoginController::class . '@login')->name('api.session');
Route::post('/session/refresh', \Api\Http\Controllers\Auth\RefreshController::class . '@refresh')->name('api.refresh');

Route::middleware('auth:api')->post('/session/destroy', \Api\Http\Controllers\Auth\LoginController::class . '@logout')->name('api.session.destroy');