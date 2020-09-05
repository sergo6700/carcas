<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/derivation-rules/list', \Api\Http\Controllers\DerivationRulesController::class . '@listable')->name('api.derivation-rules.listable');
    Route::get('/derivation-rules/collected', \Api\Http\Controllers\DerivationRulesController::class . '@collected')->name('api.derivation-rules.collected');
    Route::get('/derivation-rules/paginated', \Api\Http\Controllers\DerivationRulesController::class . '@paginated')->name('api.derivation-rules.paginated');
    Route::get('/derivation-rules/single/{id}', \Api\Http\Controllers\DerivationRulesController::class . '@single')->name('api.derivation-rules.single');
   
    Route::post('/derivation-rules/create', \Api\Http\Controllers\DerivationRulesController::class . '@create')->name('api.derivation-rules.create');
    Route::put('/derivation-rules/update/{id}', \Api\Http\Controllers\DerivationRulesController::class . '@update')->name('api.derivation-rules.update');
    Route::delete('/derivation-rules/delete/{id}', \Api\Http\Controllers\DerivationRulesController::class . '@delete')->name('api.derivation-rules.delete');

    Route::get('/derivation-rules/price-rules', \Api\Http\Controllers\DerivationRulesController::class . '@priceRules')->name('api.derivation-rules.price-rules');
});
