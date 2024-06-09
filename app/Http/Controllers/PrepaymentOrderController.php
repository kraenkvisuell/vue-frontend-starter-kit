<?php

namespace App\Http\Controllers;

use App\Actions\PlaceOrder;
use App\Actions\ProcessOrderForSite;
use App\Actions\SendAllOrderNotifications;
use App\Models\Cart;

class PrepaymentOrderController
{
    public function store(PlaceOrder $placeOrder)
    {
        $cart = Cart::where('token', request()->token)->first();

        if (! $cart) {
            abort(404);
        }

        $order = $placeOrder($cart->id);

        if ($order) {
            (new ProcessOrderForSite)($order, config('app.current_site'));
            (new SendAllOrderNotifications)($order);
        }

        return [
            'success' => $order ? true : false,
        ];
    }
}
