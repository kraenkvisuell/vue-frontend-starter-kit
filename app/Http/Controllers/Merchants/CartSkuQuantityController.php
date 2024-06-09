<?php

namespace App\Http\Controllers\Merchants;

use App\Actions\Merchants\UpdateCartSkuQuantity;
use App\Http\Resources\Merchants\CartResource;
use App\Items\Merchants\CurrentCart;

class CartSkuQuantityController
{
    public function update(UpdateCartSkuQuantity $update, CurrentCart $currentCart)
    {
        $cart = $currentCart();
        $update(cart: $cart, slug: request()->slug, quantity: request()->quantity);

        return [
            'cart' => new CartResource($currentCart()),
        ];
    }
}
