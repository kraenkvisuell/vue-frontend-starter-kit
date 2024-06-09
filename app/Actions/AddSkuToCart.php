<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\Sku;

class AddSkuToCart
{
    public function __invoke(int $skuId, Cart $cart, int $quantity): Cart
    {
        $sku = Sku::find($skuId);

        if (!$sku) {
            return $cart;
        }

        if ($cartSku = $cart->skus->where('slug', $sku->slug)->first()) {
            $cartSku->update([
                'quantity' => $cartSku->quantity + $quantity,
            ]);

            return $cart;
        }

        $cart->skus()->create([
            'slug' => $sku->slug,
            'long_title' => $sku->long_title,
            'quantity' => $quantity,
            'price_incl_vat' => $sku->price_incl_vat,
            'discount_price_incl_vat' => $sku->discount_price_incl_vat,
            'has_discount_price' => $sku->has_discount_price,
            'vat_percentage' => $sku->vat_percentage,
            'title' => $sku->title,
        ]);

        return $cart->fresh();
    }
}
