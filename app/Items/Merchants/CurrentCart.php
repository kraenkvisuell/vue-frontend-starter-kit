<?php

namespace App\Items\Merchants;

use Illuminate\Support\Facades\Auth;

class CurrentCart
{
    public function __invoke()
    {

        $merchant = Auth::guard('merchants')->user();

        $cart = $merchant->current_cart;

        if (!$cart) {
            $cart = $merchant->current_cart()->create();
        }

        return $cart::with([
            'merchant',
            'skus.order.merchant',
            'skus.original_sku.product.product_group.products.product_categories',
            'skus.original_sku.product.product_tags',
            'skus.original_sku.product.product_categories',
            'skus.original_sku.colors',
        ])->find($cart->id);

    }
}
