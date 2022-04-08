<?php

Route::middleware('auth')
    ->prefix('roles')
    ->name('roles.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\Role\IndexController::class
        )->name('index');
    });
