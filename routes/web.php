<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartPaymentKindController;
use App\Http\Controllers\CartSkuQuantityController;
use App\Http\Controllers\CartSkusController;
use App\Http\Controllers\CheckoutAddressController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\JobApplicationsController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MatchingSkusController;
use App\Http\Controllers\MessageWhenAvailableController;
use App\Http\Controllers\OldShopRedirectsController;
use App\Http\Controllers\OptimizedImagesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PrepaymentOrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RemoveVoucherCodeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopNaviController;
use App\Http\Controllers\SimilarSkusController;
use App\Http\Controllers\StripeReturnController;
use App\Http\Controllers\StripeSessionController;
use App\Http\Controllers\StripeWebhooksController;
use App\Http\Controllers\SuccessfulOrderController;
use App\Http\Controllers\UseVoucherCodesController;
use App\Http\Middleware\CustomerIsLogged;
use App\Http\Middleware\SetLocale;
use App\Models\BaseOrderSku;
use App\Models\Customer;
use App\Models\Order;
use App\Notifications\YourOrderWasPlaced;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::pattern('locale', implode('|', array_keys(config('translatable.languages'))));

Route::get('/', [PagesController::class, 'show'])->name('home.show');

Route::get('/optimized-images/{disk}/{path}', [OptimizedImagesController::class, 'show'])->where('path', '.*');

Route::post('/webhooks/stripe', [StripeWebhooksController::class, 'index']);

Route::get('/shop-navi/', [ShopNaviController::class, 'index'])->name('shop-navi');

Route::post('/registration', [RegistrationController::class, 'store'])->name('store.registration');

Route::post('/message-when-available', [MessageWhenAvailableController::class, 'store'])->name('store.message-when-available');

Route::post('/login', [LoginController::class, 'store'])->name('store.login');
Route::post('/logout', [LogoutController::class, 'store'])->name('store.logout');

Route::post('/cart/store', [CartController::class, 'store'])->name('store.cart');
Route::post('/cart-skus/store', [CartSkusController::class, 'store'])->name('store.cart-sku');
Route::post('/cart-skus/update-quantity', [CartSkuQuantityController::class, 'update'])->name('update.cart-sku-quantity');
Route::post('/cart-skus/delete', [CartSkusController::class, 'delete'])->name('delete.cart-sku');

Route::post('/checkout-address/update', [CheckoutAddressController::class, 'update'])->name('update.checkout-address');
Route::post('/cart-payment-kind/update', [CartPaymentKindController::class, 'update'])->name('update.cart-payment-kind');
Route::post('/store-prepayment-order', [PrepaymentOrderController::class, 'store'])->name('store.prepayment-order');
Route::get('/stripe/session', [StripeSessionController::class, 'store'])->name('store.stripe-session');

Route::post('/use-voucher-codes', [UseVoucherCodesController::class, 'store'])->name('store.use-voucher-codes');
Route::post('/remove-voucher-code', [RemoveVoucherCodeController::class, 'store'])->name('store.remove-voucher-code');

Route::post('/job-application', [JobApplicationsController::class, 'store'])->name('store.job-application');

Route::middleware([SetLocale::class])->group(function () {
    Route::post('/{locale}/search/store', [SearchController::class, 'store'])->name('store.search');

    Route::get('/{locale}/stripe-return', [StripeReturnController::class, 'index'])->name('stripe-return');

    Route::get('/{locale}/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/{locale}/shop/new', [ShopController::class, 'index'])->name('shop.new');
    Route::get('/{locale}/unterkategorie/{categorySlug}/{tagSlug}', [ShopController::class, 'index'])->name('shop.tag');
    Route::get('/{locale}/kategorie/{categorySlug}', [ShopController::class, 'index'])->name('shop.category');
    Route::get('/{locale}/kollektion/{productGroupSlug}', [ShopController::class, 'index'])->name('shop.product-group');

    Route::get('/{locale}/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/{locale}/successful-order/{paymentKind}', [SuccessfulOrderController::class, 'index'])->name('successful-order');

    Route::get('/{locale}/modelle/{slug}', [ProductsController::class, 'show'])->name('products.show');

    Route::get('/{locale}/jobs/{slug}', [JobsController::class, 'show'])->name('jobs.show');

    Route::get('/{locale}/matching-skus/{id}', [MatchingSkusController::class, 'index'])->name('matching-skus');
    Route::get('/{locale}/similiar-skus/{id}', [SimilarSkusController::class, 'index'])->name('similar-skus');

    if (Request::segment(1) !== config('statamic.cp.route')) {
        Route::get('/{locale}/{slug}', [PagesController::class, 'show'])->name('pages.show');
    }
});

Route::get('/{locale}/shop/{slug}', [OldShopRedirectsController::class, 'index']);

Route::permanentRedirect('/{locale}/merchant/login', '/{locale}/haendler/login');
Route::permanentRedirect('/{locale}/kollektionen', '/{locale}/shop');

Route::middleware([CustomerIsLogged::class])->group(function () {
    Route::post('/account', [AccountController::class, 'store'])->name('store.account');
});

Route::get('preview-customer-mail', function () {
    $order = Order::factory()->make();
    $order->customer()->associate(Customer::factory()->make());
    $skus = BaseOrderSku::factory()->count(3)->make();
    $order->skus = $skus;

    return (new YourOrderWasPlaced($order))->toMail($order->customer);
});
