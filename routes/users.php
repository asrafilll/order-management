<?php

Route::middleware('auth')
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
    });
