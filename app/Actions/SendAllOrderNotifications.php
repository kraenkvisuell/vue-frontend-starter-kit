<?php

namespace App\Actions;

use App\Models\Order;
use App\Notifications\YourOrderWasPlaced;

class SendAllOrderNotifications
{
    public function __invoke(Order $order)
    {
        $order->customer->notify(new YourOrderWasPlaced($order));
    }
}
