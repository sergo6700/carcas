<?php
use \Api\Http\Controllers\VatTypesController;
Route::group(['middleware' => 'auth:api'], function () {
    Route::name('api.vat-types.')->prefix('/vat-types')->group(function () {
        Route::get('list', [VatTypesController::class, 'listable'])->name('listable');
//        Route::get('paginated', [CompaniesController::class, 'paginated'])->name('paginated');
////        Route::get('vattypes', [CompaniesController::class, 'vattypes'])->name('vattypes');
//        Route::get('single/{id}', [CompaniesController::class, 'single'])->name('single');
//        Route::post('create', [CompaniesController::class, 'create'])->name('create');
//        Route::put('update/{id}', [CompaniesController::class, 'update'])->name('update');
//        Route::delete('delete/{id}', [CompaniesController::class, 'delete'])->name('delete');
    });
});
