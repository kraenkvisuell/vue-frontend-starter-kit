<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\DiscountCode;

class RemoveVoucherCodeFromCart
{
    public function __invoke($id, Cart $cart)
    {
        $cart->discount_code_usages()->where('id', $id)->delete();

        return $cart->fresh();
    }
}
