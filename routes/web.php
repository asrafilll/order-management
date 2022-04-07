<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/home');
Route::view('/home', 'home')->middleware('auth');
Route::view('/example', 'example');

require __DIR__ . '/auth.php';

Route::prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get(
            '/',
            \App\Http\Controllers\UserController\IndexController::class
        )->name('index');
    });
