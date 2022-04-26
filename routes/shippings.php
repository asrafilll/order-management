<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_shippings()->value])
    ->prefix('shippings')
    ->name('shippings.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\Shipping\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\Shipping\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\Shipping\StoreController::class
        )->name('store');
        Route::get(
            '/{shipping}',
            \App\Http\Controllers\Shipping\EditController::class
        )->name('edit');
        Route::put(
            '/{shipping}',
            \App\Http\Controllers\Shipping\UpdateController::class
        )->name('update');
        Route::delete(
            '/{shipping}',
            \App\Http\Controllers\Shipping\DestroyController::class
        )->name('destroy');
    });
