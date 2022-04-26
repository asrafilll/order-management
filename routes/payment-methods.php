<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_payment_methods()->value])
    ->prefix('payment-methods')
    ->name('payment-methods.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\PaymentMethod\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\PaymentMethod\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\PaymentMethod\StoreController::class
        )->name('store');
        Route::get(
            '/{paymentMethod}',
            \App\Http\Controllers\PaymentMethod\EditController::class
        )->name('edit');
        Route::put(
            '/{paymentMethod}',
            \App\Http\Controllers\PaymentMethod\UpdateController::class
        )->name('update');
        Route::delete(
            '/{paymentMethod}',
            \App\Http\Controllers\PaymentMethod\DestroyController::class
        )->name('destroy');
    });
