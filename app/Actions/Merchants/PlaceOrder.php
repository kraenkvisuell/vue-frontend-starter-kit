<?php

namespace App\Actions\Merchants;

use App\Models\MerchantCart;
use App\Models\MerchantOrder;

class PlaceOrder
{
    public function __invoke($cartId): MerchantOrder
    {
        $cart = MerchantCart::with([
            'merchant',
            'skus.original_sku.product.product_group',
        ])->find($cartId);

        $cart->update([
            'placed_at' => now(),
            'order_number' => $cart->nextOrderNumber(),
        ]);

        return MerchantOrder::where('id', $cart->id)->with(['skus.order'])->first();
    }
}
