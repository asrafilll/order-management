<?php

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::prefix('login')
            ->name('login.')
            ->group(function () {
                Route::middleware('guest')
                    ->group(function () {
                        Route::get(
                            '/',
                            \App\Http\Controllers\Auth\Login\IndexController::class
                        )
                            ->name('index');
                        Route::post(
                            '/',
                            \App\Http\Controllers\Auth\Login\StoreController::class
                        )->name('store');
                    });

                Route::middleware('auth')
                    ->group(function () {
                        Route::delete(
                            '/',
                            \App\Http\Controllers\Auth\Login\DestroyController::class
                        )->name('destroy');
                    });
            });
    });
