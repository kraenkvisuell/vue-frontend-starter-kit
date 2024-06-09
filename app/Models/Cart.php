<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends BaseOrder
{
    use HasFactory;

    protected $table = 'orders';

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->whereNull('placed_at');
        });
    }

    public function switchAddressableTypeToOrder()
    {
        $this->addresses()->update([
            'addressable_type' => 'order',
        ]);
    }

    public function nextOrderNumber()
    {
        return Order::where('site', $this->site)->max('order_number') + 1;
    }

    public function scopeOpen($query)
    {
        return $query->whereNull('waits_for_payment_since');
    }
}
