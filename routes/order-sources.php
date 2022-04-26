<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_order_sources()->value])
    ->prefix('order-sources')
    ->name('order-sources.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\OrderSource\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\OrderSource\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\OrderSource\StoreController::class
        )->name('store');
        Route::get(
            '/{orderSource}',
            \App\Http\Controllers\OrderSource\EditController::class
        )->name('edit');
        Route::put(
            '/{orderSource}',
            \App\Http\Controllers\OrderSource\UpdateController::class
        )->name('update');
        Route::delete(
            '/{orderSource}',
            \App\Http\Controllers\OrderSource\DestroyController::class
        )->name('destroy');
    });
