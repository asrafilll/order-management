<?php

use App\Enums\PermissionEnum;

Route::middleware(['auth', 'can:' . PermissionEnum::manage_users_and_roles()->value])
    ->prefix('roles')
    ->name('roles.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\Role\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\Role\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\Role\StoreController::class
        )->name('store');
        Route::get(
            '/{role}',
            \App\Http\Controllers\Role\EditController::class
        )->name('edit');
        Route::put(
            '/{role}',
            \App\Http\Controllers\Role\UpdateController::class
        )->name('update');
        Route::delete(
            '/{role}',
            \App\Http\Controllers\Role\DestroyController::class
        )->name('destroy');
    });
