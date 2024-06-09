<?php

namespace App\Actions;

use App\Models\Cart;

class UpdateCartPaymentKind
{
    public function __invoke(string $paymentKind, Cart $cart): void
    {
        $cart->update([
            'payment_kind_slug' => $paymentKind,
        ]);
    }
}
