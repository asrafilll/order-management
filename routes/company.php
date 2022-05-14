<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_company()->value])
    ->prefix('company')
    ->name('company.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\Company\IndexController::class
        )->name('index');
        Route::post(
            '/',
            \App\Http\Controllers\Company\StoreController::class
        )->name('store');
    });
