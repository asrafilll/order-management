<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_customers()->value])
    ->prefix('customers')
    ->name('customers.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\Customer\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\Customer\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\Customer\StoreController::class
        )->name('store');
        Route::get(
            '/{customer}',
            \App\Http\Controllers\Customer\EditController::class
        )->name('edit');
        Route::put(
            '/{customer}',
            \App\Http\Controllers\Customer\UpdateController::class
        )->name('update');
        Route::delete(
            '/{customer}',
            \App\Http\Controllers\Customer\DestroyController::class
        )->name('destroy');
    });
