<?php

namespace App\Items;

use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Support\Str;

class CurrentCart
{
    public function __invoke()
    {
        if (!session('cart_token')) {
            session(['cart_token' => Str::uuid()->toString()]);
        }

        $cart = Cart::open()->firstOrCreate(
            ['token' => session('cart_token')],
            ['site' => config('app.current_site')]
        );

        if (!$cart->customer && $customer = Customer::where('token', $cart->token)->first()) {
            $cart->customer()->associate($customer);

            $cart->updateAddressesFromCustomer();
        }

        return $cart::with([
            'skus.original_sku.product.product_group.products.product_categories',
            'skus.original_sku.product.product_tags',
            'skus.original_sku.product.product_categories',
            'skus.original_sku.colors',
            'shipping_address',
            'invoice_address',
            'payment_kind',
            'discount_code_usages.discount_code',
        ])->find($cart->id);
    }
}
