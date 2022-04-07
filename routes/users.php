<?php

Route::middleware('auth')
    ->prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\User\IndexController::class
        )->name('index');
    });
