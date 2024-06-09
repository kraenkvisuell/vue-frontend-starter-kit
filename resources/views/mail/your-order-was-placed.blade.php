{{--@formatter:off--}}
@php
use App\Service\NumberService;
@endphp
<x-mail::message>
<p style="text-transform: uppercase">{{ __('shop.order_entry_confirmation') }}</p>
<p>{{ __('shop.order_number') }}: {{ $order->order_number }}</p>
<hr>
<br><br>
{!! $intro !!}
<br><br>
@foreach($order->skus as $sku)
{{ $sku->quantity }}x {{ $sku->long_title }} ({{ $sku->slug }})<br>
{{ __('shop.single_price') }}: {{ NumberService::formattedFromCents($sku->price_incl_vat) }} {{ config('shop.currency_sign') }} // {{ __('shop.total_price') }}: {{ NumberService::formattedFromCents($sku->sumInclVat()) }} {{ config('shop.currency_sign') }}
<hr>
@endforeach
{{ __('shop.subtotal') }}: {{ NumberService::formattedFromCents($order->subtotalInclVat()) }} {{ config('shop.currency_sign') }}
<hr>
{{ __('shop.shipping_costs') }}: {{ NumberService::formattedFromCents(cents: $order->shippingCosts(), emptyStringWhenZero: false) }} {{ config('shop.currency_sign') }}
<hr>
<strong>{{ __('shop.total_price') }}: {{ NumberService::formattedFromCents($order->totalInclVat()) }} {{ config('shop.currency_sign') }}</strong><br>
<div class="small"><p>{{ __('shop.incl_vat_placeholder', ['vat' => NumberService::formatted(value: config('shop.default_vat_percentage'), forceDecimal: false)]) }}</p></div>
<br><br>
<strong>{{ __('shop.invoice_address') }}:</strong><br>
{!! $order->invoice_address->as_html !!}<br>
<br><br>
<strong>{{ __('shop.shipping_address') }}:</strong><br>
{!! $order->shipping_address->as_html !!}<br>
<br><br>
{!! $outro !!}

<br><br>

<div class="small">
{!! $revocationExplanation !!}
</div>

<x-slot:footer>
    {!! $footer !!}
</x-slot:footer>
</x-mail::message>

