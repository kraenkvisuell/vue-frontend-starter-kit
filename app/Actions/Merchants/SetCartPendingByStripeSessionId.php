<?php

namespace App\Actions\Merchants;

use App\Models\MerchantCart;

class SetCartPendingByStripeSessionId
{
    public function __invoke($stripeSessionId): bool
    {
        return MerchantCart::where('stripe_session_id', $stripeSessionId)
            ->update(['waits_for_payment_since' => now()]);
    }
}
