<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchantCart extends BaseMerchantOrder
{
    use HasFactory;

    protected $table = 'merchant_orders';

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->whereNull('placed_at');
        });
    }

    public function nextOrderNumber()
    {
        return MerchantOrder::whereHas('merchant', function ($b) {
                $b->where('site', $this->merchant->site);
            })->max('order_number') + 1;
    }

    public function scopeOpen($query)
    {
        return $query->whereNull('waits_for_payment_since');
    }
}
