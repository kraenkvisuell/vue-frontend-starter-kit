<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class BaseMerchantOrderSku extends Model implements Auditable
{
    public $table = 'merchant_order_skus';

    use AuditableTrait;
    use HasFactory;

    public $guarded = [];

    public function order()
    {
        return $this->belongsTo(BaseMerchantOrder::class, 'merchant_order_id');
    }

    public function original_sku()
    {
        return $this->belongsTo(Sku::class, 'slug', 'slug');
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->original_sku ? $this->original_sku->image : null,
        );
    }

    public function tagsString(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->original_sku?->product?->tags_string ?: '',
        );
    }

    public function productTitle(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->original_sku?->product?->long_title ?: '',
        );
    }

    public function colorTitle(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->original_sku?->colors?->first()?->title ?: '',
        );
    }

    public function singleVat()
    {
        return $this->discountedPrice() * ($this->order->defaultVatPercentage() / 100);
    }

    public function sumVat()
    {
        return $this->singleVat() * $this->quantity;
    }

    public function sum()
    {
        return $this->discountedPrice() * $this->quantity;
    }

    public function discount()
    {
        if ($this->order->merchant->discount_percentage) {
            return $this->price * ($this->order->merchant->discount_percentage / 100);
        }

        return 0;
    }

    public function discountSum()
    {
        if ($this->discount()) {
            return $this->discount() * $this->quantity;
        }

        return 0;
    }

    public function discountedPrice()
    {
        if ($this->discount()) {
            return intval($this->price - $this->discount());
        }

        return $this->price;
    }
}
