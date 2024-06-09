<?php

use App\Http\Controllers\Merchants\StripeReturnController;
use App\Http\Controllers\Merchants\StripeSessionController;
use App\Http\Controllers\Merchants\CheckoutController;
use App\Http\Controllers\SuccessfulOrderController;
use App\Http\Controllers\Merchants\AccountController;
use App\Http\Controllers\Merchants\CartController;
use App\Http\Controllers\Merchants\CartSkuQuantityController;
use App\Http\Controllers\Merchants\CartSkusController;
use App\Http\Controllers\Merchants\LoginController;
use App\Http\Controllers\Merchants\LogoutController;
use App\Http\Controllers\Merchants\NewsController;
use App\Http\Controllers\Merchants\OrderFormController;
use App\Http\Middleware\MerchantIsLogged;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merchants\MerchantPaymentOrderController;

Route::pattern('locale', implode('|', array_keys(config('translatable.languages'))));

Route::post('/haendler/login', [LoginController::class, 'store'])->name('merchants.store.login');

Route::middleware([SetLocale::class])->group(function () {
    Route::get('/{locale}/haendler/login', [LoginController::class, 'index'])->name('merchants.login');
});

Route::middleware([MerchantIsLogged::class])->group(function () {
    Route::get('/haendler/cart/show', [CartController::class, 'show'])->name('merchants.show.cart');
    Route::post('/haendler/cart-skus/update-quantity', [CartSkuQuantityController::class, 'update'])->name('merchants.update.cart-sku-quantity');
    Route::post('/haendler/cart-skus/delete', [CartSkusController::class, 'delete'])->name('merchants.delete.cart-sku');

    Route::post('/haendler/logout', [LogoutController::class, 'store'])->name('merchants.store.logout');
    Route::post('/haendler/account', [AccountController::class, 'store'])->name('store.account');

    Route::post('/haendler/store-merchant-payment-order', [MerchantPaymentOrderController::class, 'store'])
        ->name('merchants.store.merchant-payment-order');

    Route::get('/haendler/bestellformular', [OrderFormController::class, 'index'])->name('merchants.order-form');
    Route::get('/haendler/news', [NewsController::class, 'index'])->name('merchants.news');
    Route::get('/haendler/checkout', [CheckoutController::class, 'index'])->name('merchants.checkout');

    Route::get('/haendler/stripe-return', [StripeReturnController::class, 'index'])->name('stripe-return');

    Route::get('/haendler/stripe/session', [StripeSessionController::class, 'store'])->name('merchants.store.stripe-session');
    Route::get('/haendler/successful-order', [SuccessfulOrderController::class, 'index'])
        ->name('merchants.successful-order');
});


