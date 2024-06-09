<?php

namespace App\Http\Controllers;

use App\Actions\AddSkuToCart;
use App\Actions\DeleteCartSku;
use App\Http\Resources\CartResource;
use App\Items\CurrentCart;

class CartSkusController
{
    public function store(AddSkuToCart $addSkuToCart, CurrentCart $currentCart)
    {
        $cart = $currentCart();

        if (! $cart) {
            abort(404);
        }

        $addSkuToCart(skuId: request()->id, cart: $cart, quantity: request()->quantity);

        return [
            'cart' => new CartResource($currentCart()),
        ];
    }

    public function delete(DeleteCartSku $delete, CurrentCart $currentCart)
    {
        $delete(cartSkuId: request()->id);

        return [
            'cart' => new CartResource($currentCart()),
        ];
    }
}
