<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_users_and_roles()->value])
    ->prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\User\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\User\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\User\StoreController::class
        )->name('store');
        Route::get(
            '/{user}/edit',
            \App\Http\Controllers\User\EditController::class,
        )->name('edit');
        Route::put(
            '/{user}',
            \App\Http\Controllers\User\UpdateController::class,
        )->name('update');
        Route::put(
            '/{user}/password',
            \App\Http\Controllers\User\Password\UpdateController::class,
        )->name('update.password');
        Route::delete(
            '/{user}',
            \App\Http\Controllers\User\DestroyController::class,
        )->name('destroy');
    });
