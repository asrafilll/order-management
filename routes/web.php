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
require __DIR__ . '/users.php';
require __DIR__ . '/roles.php';
require __DIR__ . '/products.php';
require __DIR__ . '/employees.php';
require __DIR__ . '/shippings.php';
require __DIR__ . '/order-sources.php';
