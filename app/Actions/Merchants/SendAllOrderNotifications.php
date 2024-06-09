<?php

namespace App\Actions\Merchants;

use App\Models\MerchantOrder;
use App\Notifications\Merchants\YourOrderWasPlaced;

class SendAllOrderNotifications
{
    public function __invoke(MerchantOrder $order)
    {
        $order->merchant->notify(new YourOrderWasPlaced($order));
    }
}
