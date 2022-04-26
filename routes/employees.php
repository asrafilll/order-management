<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_employees()->value])
    ->prefix('employees')
    ->name('employees.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\Employee\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\Employee\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\Employee\StoreController::class
        )->name('store');
        Route::get(
            '/{employee}',
            \App\Http\Controllers\Employee\EditController::class
        )->name('edit');
        Route::put(
            '/{employee}',
            \App\Http\Controllers\Employee\UpdateController::class
        )->name('update');
        Route::delete(
            '/{employee}',
            \App\Http\Controllers\Employee\DestroyController::class
        )->name('destroy');
    });
