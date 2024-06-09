<?php

namespace App\Http\Controllers;

use App\Actions\UpdateCartPaymentKind;
use App\Http\Resources\CartResource;
use App\Items\CurrentCart;

class CartPaymentKindController
{
    public function update(UpdateCartPaymentKind $update, CurrentCart $currentCart)
    {
        $update(paymentKind: request()->paymentKind, cart: $currentCart());

        return [
            'cart' => new CartResource($currentCart()),
        ];
    }
}
