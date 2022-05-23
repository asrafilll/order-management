<?php

use Illuminate\Support\Facades\Route;

Route::get('provinces', \App\Http\Controllers\WebApi\ProvinceController::class)->name('provinces.index');
Route::get('cities', \App\Http\Controllers\WebApi\CityController::class)->name('cities.index');
Route::get('subdistricts', \App\Http\Controllers\WebApi\SubdistrictController::class)->name('subdistricts.index');
Route::get('villages', \App\Http\Controllers\WebApi\VillageController::class)->name('villages.index');
Route::middleware(['auth'])
    ->group(function () {
        Route::get('customers', \App\Http\Controllers\WebApi\CustomerController::class)->name('customers.index');
        Route::get('order-sources', \App\Http\Controllers\WebApi\OrderSourceController::class)->name('order-sources.index');
        Route::get('order-sources/orders', \App\Http\Controllers\WebApi\OrderSourceOrderController::class)->name('order-sources.orders.index');
        Route::get('product-variants', \App\Http\Controllers\WebApi\ProductVariantController::class)->name('product-variants.index');
        Route::get('employees', \App\Http\Controllers\WebApi\EmployeeController::class)->name('employees.index');
        Route::get('shippings', \App\Http\Controllers\WebApi\ShippingController::class)->name('shippings.index');
        Route::get('payment-methods', \App\Http\Controllers\WebApi\PaymentMethodController::class)->name('payment-methods.index');
        Route::get('orders', \App\Http\Controllers\WebApi\OrderController::class)->name('orders.index');
        Route::get('order-items', \App\Http\Controllers\WebApi\OrderItemController::class)->name('order-items.index');
        Route::get('customer-types/customers', \App\Http\Controllers\WebApi\CustomerTypeCustomerController::class)->name('customer-types.customers.index');
    });
