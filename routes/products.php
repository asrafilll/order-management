<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_products()->value])
    ->prefix('products')
    ->name('products.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\Product\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\Product\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\Product\StoreController::class
        )->name('store');
        Route::get(
            '/{product:slug}',
            \App\Http\Controllers\Product\EditController::class
        )->name('edit');
        Route::put(
            '/{product:slug}',
            \App\Http\Controllers\Product\UpdateController::class
        )->name('update');
        Route::delete(
            '/{product:slug}',
            \App\Http\Controllers\Product\DestroyController::class
        )->name('destroy');
    });
