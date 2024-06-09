<?php

namespace App\Actions;

use App\Models\Cart;

class SetCartPendingByStripeSessionId
{
    public function __invoke($stripeSessionId): bool
    {
        return Cart::where('stripe_session_id', $stripeSessionId)
            ->open()
            ->update(['waits_for_payment_since' => now()]);
    }
}
