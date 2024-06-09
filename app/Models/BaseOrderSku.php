<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class BaseOrderSku extends Model implements Auditable
{
    protected $table = 'order_skus';

    use AuditableTrait;
    use HasFactory;

    protected $guarded = [];

    public function original_sku()
    {
        return $this->belongsTo(Sku::class, 'slug', 'slug');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->original_sku ? $this->original_sku->image : null,
        );
    }

    protected function tagsString(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->original_sku?->product?->tags_string ?: '',
        );
    }

    protected function productTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->original_sku?->product?->long_title ?: '',
        );
    }

    protected function colorTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->original_sku?->colors?->first()?->title ?: '',
        );
    }

    public function sumInclVat()
    {
        return $this->price_incl_vat * $this->quantity;
    }
}
