<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use StatamicRadPack\Runway\Traits\HasRunwayResource;

class Merchant extends Authenticatable implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRunwayResource;
    use Notifiable;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'first_login_at' => 'datetime',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(MerchantOrder::class)->orderBy('id', 'desc');
    }

    public function current_cart(): HasOne
    {
        return $this->hasOne(MerchantCart::class)->open()->orderBy('id', 'desc');
    }

    public function latest_order(): HasOne
    {
        return $this->hasOne(MerchantOrder::class)->latest();
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function main_address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')
            ->orderBy('type', 'desc')
            ->where('type', 'main')
            ->orWhere('type', 'invoice');
    }

    public function shipping_address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')->where('type', 'shipping');
    }

    public function invoice_address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')->where('type', 'invoice');
    }

    public function companyName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->main_address?->company ?: '',
        );
    }
}
