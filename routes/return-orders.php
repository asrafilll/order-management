<?php

Route::middleware(['auth'])
    ->prefix('return-orders')
    ->name('return-orders.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\ReturnOrder\IndexController::class
        )->name('index');
        Route::get(
            '/create',
            \App\Http\Controllers\ReturnOrder\CreateController::class
        )->name('create');
        Route::post(
            '/',
            \App\Http\Controllers\ReturnOrder\StoreController::class
        )->name('store');
        Route::get(
            '/{returnOrder}/edit',
            \App\Http\Controllers\ReturnOrder\EditController::class
        )->name('edit');
        Route::put(
            '/{returnOrder}/status',
            \App\Http\Controllers\ReturnOrder\Status\UpdateController::class
        )->name('status.update');
    });
