<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\Order;

class PlaceOrder
{
    public function __invoke($cartId): Order
    {
        $cart = Cart::with([
            'customer',
            'skus.original_sku.product.product_group',
        ])->find($cartId);

        if (! $cart->customer) {
            (new CreateTempCustomer)($cart);
        }

        $cart->update([
            'placed_at' => now(),
            'order_number' => $cart->nextOrderNumber(),
        ]);

        $cart->switchAddressableTypeToOrder();

        return Order::find($cart->id);
    }
}
