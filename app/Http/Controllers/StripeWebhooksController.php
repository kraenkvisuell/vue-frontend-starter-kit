<?php

namespace App\Http\Controllers;

use App\Actions\FullFillStripePayment;
use App\Actions\Merchants\FullFillStripePayment as MerchantsFullFillStripePayment;
use App\Actions\PlaceOrder;
use App\Actions\Merchants\PlaceOrder as MerchantPlaceOrder;
use App\Actions\ProcessOrderForSite;
use App\Actions\Merchants\ProcessOrderForSite as MerchantProcessOrderForSite;
use App\Actions\SendAllOrderNotifications;
use App\Actions\Merchants\SendAllOrderNotifications as MerchantSendAllOrderNotifications;
use App\Actions\SetCartPendingByStripeSessionId;
use App\Actions\Merchants\SetCartPendingByStripeSessionId as MerchantSetCartPendingByStripeSessionId;
use App\Actions\StoreWebhook;

class StripeWebhooksController extends Controller
{
    public function index()
    {
        $payload = request()->all();

        (new StoreWebhook)(payload: $payload);

        if ($payload['type'] === 'payment_intent.succeeded') {
            $this->onPaymentIntentSucceeded($payload);
        }

        if ($payload['type'] === 'checkout.session.completed') {
            $this->onCheckoutSessionCompleted($payload);
        }
    }

    protected function onPaymentIntentSucceeded($payload): bool
    {
        $kind = $payload['data']['oblject']['metadata']['kind'] ?? 'none';

        if ($kind === 'b2c') {
            return $this->b2cPaymentIntentSucceeded($payload);
        } elseif ($kind === 'merchant') {
            return $this->merchantPaymentIntentSucceeded($payload);
        }

    }

    protected function b2cPaymentIntentSucceeded($payload): bool
    {
        $cart = (new FullFillStripePayment)($payload);

        if (!$cart) {
            return false;
        }

        $order = (new PlaceOrder)($cart->id);

        if (!$order) {
            return false;
        }

        (new ProcessOrderForSite)($order, config('app.current_site'));

        return (bool)(new SendAllOrderNotifications)($order);
    }

    protected function merchantPaymentIntentSucceeded($payload): bool
    {
        $cart = (new MerchantsFullFillStripePayment)($payload);

        if (!$cart) {
            return false;
        }

        $order = (new MerchantPlaceOrder)($cart->id);

        if (!$order) {
            return false;
        }

        (new MerchantProcessOrderForSite)($order, config('app.current_site'));

        return (bool)(new MerchantSendAllOrderNotifications)($order);
    }

    protected function onCheckoutSessionCompleted($payload): bool
    {
        $kind = $payload['data']['oblject']['metadata']['kind'] ?? 'none';

        if ($kind === 'b2c') {
            return $this->b2cCheckoutSessionCompleted($payload);
        } elseif ($kind === 'merchant') {
            return $this->merchantCheckoutSessionCompleted($payload);
        }
    }

    protected function b2cCheckoutSessionCompleted($payload): bool
    {
        return (new SetCartPendingByStripeSessionId)($payload['data']['object']['id']) ? true : false;
    }

    protected function merchantCheckoutSessionCompleted($payload): bool
    {
        return (new MerchantSetCartPendingByStripeSessionId)($payload['data']['object']['id']) ? true : false;
    }
}
