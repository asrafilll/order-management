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
    });
