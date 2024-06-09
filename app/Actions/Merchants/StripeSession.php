<?php

namespace App\Actions\Merchants;

use Illuminate\Support\Str;
use App\Items\Merchants\CurrentCart;
use Stripe\StripeClient;

class StripeSession
{
    public function __invoke()
    {
        $cart = (new CurrentCart)();

        if (!$cart->skus->count()) {
            return null;
        }

        $stripe = new StripeClient(config('services.stripe')[config('app.current_site')]['secret']);

        $checkoutSession = $stripe->checkout->sessions->create($this->getParams($cart));

        $cart->update(['stripe_session_id' => $checkoutSession->id]);

        return $checkoutSession->client_secret;
    }

    protected function getMetadata($cart): array
    {
        return [
            'bestellungs_id' => $cart->id,
            'kind' => 'merchant',
            'articles' => $cart->skus->map(function ($item) {
                return [
                    'quantity' => $item->quantity,
                    'number' => $item->slug,
                ];
            }),
            'rechnungsadresse_name' => $cart->merchant->invoice_address?->full_name,
            'rechnungsadresse_firma' => $cart->merchant->invoice_address?->company,
            'rechnungsadresse_strasse' => $cart->merchant->invoice_address?->street,
            'rechnungsadresse_strasse_erweitert' => $cart->merchant->invoice_address?->additional_field,
            'rechnungsadresse_plz' => $cart->merchant->invoice_address?->postcode,
            'rechnungsadresse_ort' => $cart->merchant->invoice_address?->city,
            'rechnungsadresse_land' => $cart->merchant->invoice_address?->country_iso,
            'rechnungsadresse_telefon' => $cart->merchant->invoice_address?->phone,
            'lieferadresse_name' => $cart->merchant->shipping_address?->full_name,
            'lieferadresse_firma' => $cart->merchant->shipping_address?->company,
            'lieferadresse_strasse' => $cart->merchant->shipping_address?->street,
            'lieferadresse_strasse_erweitert' => $cart->merchant->shipping_address?->additional_field,
            'lieferadresse_plz' => $cart->merchant->shipping_address?->postcode,
            'lieferadresse_ort' => $cart->merchant->shipping_address?->city,
            'lieferadresse_land' => $cart->merchant->shipping_address?->country_iso,
            'lieferadresse_telefon' => $cart->merchant->shipping_address?->phone,
        ];
    }

    protected function getParams($cart): array
    {
        $itemString = 'Händler-Bestellung bei ZWEI / Kunde '
            . $cart->merchant->number . ' / '
            . implode(', ', $cart->skus->map(function ($item) {
                return $item->quantity . ' x ' . $item->title;
            })->toArray());

        $params = [
            'ui_mode' => 'embedded',
            'locale' => 'de',
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => config('shop.currencies')[config('app.current_site')],
                    'product_data' => [
                        'name' => Str::limit($itemString, 100),
                    ],
                    'unit_amount' => $cart->total(),
                ],
            ]],
            'mode' => 'payment',
            'return_url' => config('app.url') . '/haendler/stripe-return?session_id={CHECKOUT_SESSION_ID}',
            'payment_intent_data' => [
                'metadata' => $this->getMetadata($cart),
            ],
        ];

        if ($cart->merchant->email) {
            $params['customer_email'] = $cart->merchant->email;
        }

        return $params;
    }
}
