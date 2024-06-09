<?php

namespace App\Actions\Merchants;

use App\Models\MerchantCart;

class FullFillStripePayment
{
    public function __invoke($payload): ?MerchantCart
    {
        $cart = MerchantCart::where('id', (intval($payload['data']['object']['metadata']['bestellungs_id'] ?? null)))->first();

        if (!$cart) {
            return null;
        }

        $cart->update([
            'paid_at' => now(),
            'stripe_payment_kind' => $payload['data']['object']['payment_method_types'][0] ?? null,
            'stripe_payment_intent_id' => $payload['id'] ?? null,
        ]);

        return $cart;
    }
}
