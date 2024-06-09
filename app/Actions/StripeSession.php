<?php

namespace App\Actions;

use App\Items\CurrentCart;
use Stripe\StripeClient;
use Illuminate\Support\Str;
use App\Service\NumberService;

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
            'kind' => 'b2c',
            'articles' => $cart->skus->map(function ($item) {
                return [
                    'quantity' => $item->quantity,
                    'number' => $item->slug,
                ];
            }),
            'rabatt' => NumberService::formattedFromCents($cart->totalAllDiscounts()),
            'rechnungsadresse_name' => $cart->invoice_address?->full_name,
            'rechnungsadresse_firma' => $cart->invoice_address?->company,
            'rechnungsadresse_strasse' => $cart->invoice_address?->street,
            'rechnungsadresse_strasse_erweitert' => $cart->invoice_address?->additional_field,
            'rechnungsadresse_plz' => $cart->invoice_address?->postcode,
            'rechnungsadresse_ort' => $cart->invoice_address?->city,
            'rechnungsadresse_land' => $cart->invoice_address?->country_iso,
            'rechnungsadresse_telefon' => $cart->invoice_address?->phone,
            'lieferadresse_name' => $cart->actual_shipping_address?->full_name,
            'lieferadresse_firma' => $cart->actual_shipping_address?->company,
            'lieferadresse_strasse' => $cart->actual_shipping_address?->street,
            'lieferadresse_strasse_erweitert' => $cart->actual_shipping_address?->additional_field,
            'lieferadresse_plz' => $cart->actual_shipping_address?->postcode,
            'lieferadresse_ort' => $cart->actual_shipping_address?->city,
            'lieferadresse_land' => $cart->actual_shipping_address?->country_iso,
            'lieferadresse_telefon' => $cart->actual_shipping_address?->phone,
        ];
    }

    protected function getParams($cart): array
    {
        $itemString = 'Bestellung bei ZWEI / '
            . $cart->invoice_address?->full_name . ' / '
            . implode(', ', $cart->skus->map(function ($item) {
                return $item->quantity . ' x ' . $item->title;
            })->toArray());

        $params = [
            'ui_mode' => 'embedded',
            'locale' => app()->getLocale(),
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => config('shop.currencies')[config('app.current_site')],
                    'product_data' => [
                        'name' => Str::limit($itemString, 100)

                    ],
                    'unit_amount' => $cart->totalInclVat(),
                ],
            ]],
            'mode' => 'payment',
            'return_url' => config('app.url') . '/' . app()->getLocale() . '/stripe-return?session_id={CHECKOUT_SESSION_ID}',
            'payment_intent_data' => [
                'metadata' => $this->getMetadata($cart),
            ],
        ];

        if ($cart->invoice_address?->email) {
            $params['customer_email'] = $cart->invoice_address->email;
        }

        return $params;
    }
}
