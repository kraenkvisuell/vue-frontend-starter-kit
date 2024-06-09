{{--@formatter:off--}}
<x-mail::message>
{{ __('shop.article_available_again') }}:
<br><br>
<a href="{{ route('products.show', [$availabilityReminder->locale, $sku->product->slug]) }}#{{ $sku->color?->slug }}">
{{ $sku->product?->long_title }} {{ strtoupper($sku->color?->title) }}
</a>
<br>
<x-slot:footer>
    {!! $footer !!}
</x-slot:footer>
</x-mail::message>

