<?php

namespace App\Http\Controllers\Merchants;

use App\Items\Merchants\CurrentCart;
use App\Actions\Merchants\PlaceOrder;
use App\Actions\Merchants\ProcessOrderForSite;
use App\Actions\Merchants\SendAllOrderNotifications;

class MerchantPaymentOrderController
{
    public function store(PlaceOrder $placeOrder, CurrentCart $currentCart)
    {
        $order = $placeOrder($currentCart()->id);

        if ($order) {
            (new ProcessOrderForSite)($order, config('app.current_site'));
            (new SendAllOrderNotifications)($order);
        }

        return [
            'success' => $order ? true : false,
        ];
    }
}
