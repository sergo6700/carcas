<?php

Route::get('/translations', \Api\Http\Controllers\TranslationsController::class . '@get')->name('api.translations');
