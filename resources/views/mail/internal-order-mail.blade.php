{{--@formatter:off--}}
@inject('numberHelper', 'App\Service\NumberService')
@inject('stringHelper', 'App\Service\StringService')
ONLINESHOP Bestellnummer {{ $order->order_number }}
{{ $order->shipping_address->country_iso }} {{ strtoupper($order->referer) }}
{{ $order->created_at->format('d.m.Y') }}
{{ $order->payment_kind_slug }}
@if ($order->payment_kind->internal_type == 'stripe' && ($order->stripe_payment_intent_id || $order->stripe_session_id))
{{ $order->stripe_payment_intent_id ?: $order->stripe_session_id }}
@else

@endif
{{ $order->invoice_address->first_name }}
{{ $order->invoice_address->last_name }}
{{ $order->invoice_address->company }}
{{ $order->invoice_address->street }}
{{ $order->invoice_address->postcode }}
{{ $order->invoice_address->city }}
{{ $order->invoice_address->email }}
{{ $order->invoice_address->phone }}
{{ $order->invoice_address->country_iso }}

Lieferadresse:
{{ $order->shipping_address->first_name }}
{{ $order->shipping_address->last_name }}
{{ $order->shipping_address->company }}
{{ $order->shipping_address->street }}
{{ $order->shipping_address->postcode }}
{{ $order->shipping_address->city }}
{{ $order->shipping_address->email }}
{{ $order->shipping_address->phone }}
{{ $order->shipping_address->country_iso }}

{{ $order->cryptcode }}{{ $order->cryptcode ? '          '.$order->filemaker_readable_cryptcode_percentage.'% Rabatt' : '' }}{{ $order->voucher?->code }}{{ $order->voucher ? ':'.$order->filemaker_voucher_discount : '' }}{{ $order->onetime_code?->code }}{{ $order->onetime_code ? ':'.$order->filemaker_onetime_code_discount : '' }}
{{ $numberHelper->stringFromFloat($order->vat_percentage) }}


EUR {{ $numberHelper->formattedFromCents($order->totalInclVat()) }}

@if($order->skus)
@foreach ($order->skus as $n => $sku)
{{ $sku->is_voucher ? 'GUTO:+'.$sku->filemaker_price.'       ' : strtoupper($sku->title) }}@if(!$sku->is_voucher){{ $stringHelper->repeatBlank(19 - strlen($sku->title)) }}@endif{{ $sku->quantity < 100 ? '0' : '' }}{{ $sku->quantity < 10 ? '0' : '' }}{{ $sku->quantity }}@if($sku->is_voucher){{ $stringHelper->repeatBlank(7).optional($sku->voucher)->code.':'.$sku->filemaker_price }}@endif @if($sku->is_additional_product || $sku->productcode){{ $stringHelper->repeatBlank(6).
    ($sku->is_additional_product ? 'ERGAENZUNG:-' : 'RABATTNR:'.strtoupper($sku->productcode_code).':-').$numberHelper->floatForFilemaker($sku->is_additional_product ? $sku->percent_when_additional_product : $sku->productcode->percentage) }}@endif

@if($sku->packaging_number)
{{ strtoupper($sku->packaging_number) }}{{ $stringHelper->repeatBlank(19 - strlen($sku->packaging_number)) }}{{ $sku->quantity < 100 ? '0' : '' }}{{ $sku->quantity < 10 ? '0' : '' }}{{ $sku->quantity }}{{ $stringHelper->repeatBlank(7).'FUER'.($sku->boxcode ? 'X' : '').':'.strtoupper($sku->title) }}{{ $sku->boxcode ? '/RABATTCODE:'.strtoupper($sku->boxcode) : '' }}
@endif
@endforeach
@endif
@if($order->co2_price_accepted && $order->totalCo2Price())
CO2KOMP{{ $stringHelper->repeatBlank(12) }}{{ $order->co2PriceQuantity() < 100 ? '0' : '' }}{{ $order->co2PriceQuantity() < 10 ? '0' : '' }}{{ $order->co2PriceQuantity() }}
@endif
@if($order->plastic_compensation_accepted && $order->totalPlasticCompensation())
OPKOMP{{ $stringHelper->repeatBlank(13) }}{{ $order->plasticCompensationQuantity() < 100 ? '0' : '' }}{{ $order->plasticCompensationQuantity() < 10 ? '0' : '' }}{{ $order->plasticCompensationQuantity() }}
@endif
@foreach($order->voucher_usages as $usage)
GUTO:-{{ $usage->getFilemakerAmount().'       001       '.$usage->voucher->code.':'.$usage->voucher->filemaker_rest }}
@endforeach
@if($order->cryptcode)
GUTO:-{{ $order->readable_reduction_by_cryptcode.'       001       '.$order->cryptcode.':0' }}
@endif
@if($order->promocode)
GUTO:-{{ $order->filemaker_promocode_discount.'       001       '.$order->actual_discount_code.':0' }}
@endif
@if($order->onetime_code)
GUTO:-{{ $order->filemaker_onetime_code_discount.'       001       '.$order->onetime_code->code.':'.$order->onetime_code->filemaker_rest }}
@endif
@if($order->passesForDonation())
SPENDE{{ '             001' }}
@endif
~~~
{{ $order->message }}
