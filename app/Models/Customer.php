<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
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

class Customer extends Authenticatable implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRunwayResource;
    use Notifiable;
    use Prunable;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'registered_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    public function prunable()
    {
        return static::whereNull('registered_at')->where('created_at', '<=', now()->subWeek());
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->latest();
    }

    public function current_cart(): HasOne
    {
        return $this->hasOne(Cart::class)->latest();
    }

    public function latest_order(): HasOne
    {
        return $this->hasOne(Order::class)->latest();
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function shipping_address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')->where('type', 'shipping');
    }

    public function invoice_address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')->where('type', 'invoice');
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name.' '.$this->last_name,
        );
    }
}
