<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_orders()->value])
    ->prefix('orders')
    ->name('orders.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\Order\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\Order\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\Order\StoreController::class
        )->name('store');
        Route::get(
            '/{order}',
            \App\Http\Controllers\Order\EditController::class
        )->name('edit');
        Route::put(
            '/{order}',
            \App\Http\Controllers\Order\UpdateController::class
        )->name('update');
        Route::delete(
            '/{order}',
            \App\Http\Controllers\Order\DestroyController::class
        )->name('destroy');
        Route::get(
            '/{order}/general-information',
            \App\Http\Controllers\Order\GeneralInformation\EditController::class
        )->name('general-information.edit');
        Route::put(
            '/{order}/general-information',
            \App\Http\Controllers\Order\GeneralInformation\UpdateController::class
        )->name('general-information.update');
        Route::post(
            '/{order}/items',
            \App\Http\Controllers\Order\Item\StoreController::class
        )->name('items.store');
    });
