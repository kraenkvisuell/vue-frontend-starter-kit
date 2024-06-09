<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\DiscountCode;

class AddDiscountsAndVouchersToCart
{
    public function __invoke(string $codes, Cart $cart)
    {
        $codes = array_unique(array_map('strtoupper', array_map('trim', explode(',', $codes))));

        foreach ($codes as $code) {
            if ($discountCode = DiscountCode::findUsable($code, config('app.current_site'), $cart)) {
                (new AddDiscountCodeToCart)(discountCode: $discountCode, cart: $cart);
            }
        }

        return $cart->fresh();
    }
}
