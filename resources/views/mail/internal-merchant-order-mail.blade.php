{{--@formatter:off--}}
@inject('numberHelper', 'App\Service\NumberService')
@inject('stringHelper', 'App\Service\StringService')
B2B Order{{ $order->filled_via_upload ? 'x' : ' '}}{{ $order->order_number }}
{{ $order->merchant->merchant_number }}
{{ $order->created_at->format('d.m.Y') }}
{{ $order->merchant->shipping_address->internal_address_key }}
{{ $order->call_me_before_shipment ? 'Kunde bittet um RR' : '' }}
{{ $order->master_user ? $order->master_user->email : '' }}
{{ $order->stripe_payment_intent_id ? 'Online-Zahlung: '.$order->stripe_payment_intent_id : '' }}
{{ $order->inspiration ? 'Kaufempfehlung '.$order->inspiration : '' }}
{{ $order->custom_order_number }}
{{ $order->preferred_shipping_date }}
{{ $numberHelper->formattedFromCents($order->total()) }}
{{ $order->ordersForChild() ? 'Filialbestellung durch KdNr: '.$order->merchant->merchant_number : '' }}
@if($order->skus)
    @foreach ($order->skus as $n => $sku)
        {{ strtoupper($sku->title) }}{{ $stringHelper->repeatBlank(19 - strlen($sku->title)) }}{{ $sku->quantity < 100 ? '0' : '' }}{{ $sku->quantity < 10 ? '0' : '' }}{{ $sku->quantity }}
    @endforeach
@endif
@if($order->co2_price_accepted && $order->totalCo2Price())
    CO2KOMP{{ $stringHelper->repeatBlank(12) }}{{ $order->co2PriceQuantity() < 100 ? '0' : '' }}{{ $order->co2PriceQuantity() < 10 ? '0' : '' }}{{ $order->co2PriceQuantity() }}
@endif
@if($order->plastic_compensation_accepted && $order->totalPlasticCompensation())
    OPKOMP{{ $stringHelper->repeatBlank(13) }}{{ $order->plasticCompensationQuantity() < 100 ? '0' : '' }}{{ $order->plasticCompensationQuantity() < 10 ? '0' : '' }}{{ $order->plasticCompensationQuantity() }}
@endif
~~~
{{ $order->message }}
