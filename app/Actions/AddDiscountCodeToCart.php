<?php

namespace App\Actions;

use App\Models\Sku;
use App\Models\Cart;
use App\Models\DiscountCode;

class AddDiscountCodeToCart
{
    public function __invoke(DiscountCode $discountCode, Cart $cart)
    {
        $orderSkuId = null;
        if ($discountCode->mode === 'sku') {
            if (
                !$cart->skus->firstWhere('slug', $discountCode->sku_number)
                && $sku = Sku::where('slug', $discountCode->sku_number)->first()
            ) {
                $cart = (new AddSkuToCart)(skuId: $sku->id, cart: $cart, quantity: 1);
            }

            $orderSkuId = $cart->skus->firstWhere('slug', $discountCode->sku_number)?->id;
        }

        $amount = null;
        if ($discountCode->mode === 'absolute') {
            $total = $cart->subtotalInclVat();
            $amount = $total < $discountCode->amount ? $total : $discountCode->amount;
        }

        $cart->discount_code_usages()->create([
            'discount_code_id' => $discountCode->id,
            'order_sku_id' => $orderSkuId,
            'amount' => $amount,
        ]);
    }
}
