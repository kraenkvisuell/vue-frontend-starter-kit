<?php

namespace App\Http\Controllers;

use App\Items\CurrentCart;
use App\Http\Resources\CartResource;
use App\Actions\RemoveVoucherCodeFromCart;

class RemoveVoucherCodeController extends Controller
{
    public function store(
        RemoveVoucherCodeFromCart $removeFromCart,
        CurrentCart $currentCart
    )
    {
        $cart = $currentCart();

        if (!$cart) {
            abort(404);
        }

        $removeFromCart(request()->input('id'), cart: $cart);

        return [
            'cart' => new CartResource($currentCart()),
        ];
    }
}
