<?php

use App\Actions\PlaceOrder;
use App\Models\Address;
use App\Models\BaseOrderSku;
use App\Models\Cart;
use App\Models\Order;
use App\Notifications\YourOrderWasPlaced;
use Illuminate\Support\Facades\Notification;

test('placing order converts cart to order', function () {
    $cart = Cart::factory()->has(BaseOrderSku::factory()->count(1), 'skus')->create();
    $cartId = $cart->id;

    expect($cart->shipping_address)->toBeInstanceOf(Address::class)
        ->and($cart->invoice_address)->toBeInstanceOf(Address::class)
        ->and(Order::find($cartId))->toBe(null);

    (new PlaceOrder())($cart->id);

    $order = Order::find($cartId);
    expect($order)->not->toBe(null)->toBeInstanceOf(Order::class)
        ->and($order->shipping_address)->toBeInstanceOf(Address::class)
        ->and($order->invoice_address)->toBeInstanceOf(Address::class);
});

test('placing order sets next order number for site', function () {
    Order::factory()->create(['order_number' => 10]);

    $cart = Cart::factory()->has(BaseOrderSku::factory()->count(1), 'skus')->create();

    (new PlaceOrder())($cart->id);

    $order = Order::find($cart->id);

    expect($order->order_number)->toBe(11);
});

test('creating new order number ignores other site', function () {
    Order::factory()->create(['order_number' => 10, 'site' => 'other-site']);

    $cart = Cart::factory()->has(BaseOrderSku::factory()->count(1), 'skus')->create();

    (new PlaceOrder())($cart->id);

    $order = Order::find($cart->id);

    expect($order->order_number)->toBe(1);
});

test('placing order sends customer notification', function () {
    Notification::fake();

    $cart = Cart::factory()->has(BaseOrderSku::factory()->count(1), 'skus')->create();

    $this->post(route('store.prepayment-order', ['token' => $cart->token]));
    
    Notification::assertSentTo([$cart->fresh()->customer], YourOrderWasPlaced::class);
});
