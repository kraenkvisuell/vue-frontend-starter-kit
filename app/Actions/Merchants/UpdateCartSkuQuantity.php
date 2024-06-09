<?php

namespace App\Actions\Merchants;

use App\Models\MerchantCart;
use App\Models\Sku;

class UpdateCartSkuQuantity
{
    public function __invoke(MerchantCart $cart, string $slug, int $quantity): void
    {
        $sku = Sku::where('slug', $slug)->first();

        if (! $sku) {
            $sku = Sku::make([
                'slug' => 'notavailable',
                'title' => 'notavailable',
                'merchant_price' => 0,
                'vat_percentage' => 19,
            ]);
        }

        if ($cartSku = $cart->skus->firstWhere('slug', $slug)) {
            if ($quantity) {
                $cartSku->update([
                    'quantity' => $quantity,
                ]);
            } else {
                $cartSku->delete();
            }

            return;
        }

        $cart->skus()->create([
            'slug' => $slug,
            'long_title' => $sku->long_title,
            'quantity' => $quantity,
            'price' => $sku->merchant_price,
            'vat_percentage' => $sku->vat_percentage,
            'title' => $sku->title,
        ]);
    }
}
