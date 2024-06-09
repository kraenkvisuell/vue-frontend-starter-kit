<?php

namespace App\Models;

use App\Service\DateService;
use Laravel\Scout\Searchable;
use App\Service\NumberService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use StatamicRadPack\Runway\Traits\HasRunwayResource;

class DiscountCode extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use HasRunwayResource;
    use SoftDeletes;
    use Searchable;

    protected $guarded = [];

    protected $casts = [
        'active_from' => 'date',
        'active_until' => 'date',
    ];

    public function searchableAs(): string
    {
        return 'discount_codes';
    }

    public function toSearchableArray()
    {
        return [
            'code' => $this->code,
            'description' => $this->description,
        ];
    }

    public function getScoutKey(): mixed
    {
        return $this->code;
    }

    public function getScoutKeyName(): mixed
    {
        return 'code';
    }

    public function discount_usages(): HasMany
    {
        return $this->hasMany(DiscountCodeUsage::class);
    }

    public static function findUsable(string $code, string $site, Cart $cart): static|null
    {
        $discountCode = static::with('discount_usages')->where('code', $code)->where('site', $site)->usable()->first();

        if (!$discountCode) {
            return null;
        }

        if ($cart->discount_code_usages->where('id', $discountCode->id)->count()) {
            return null;
        }

        if ($discountCode->mode === 'absolute') {
            $sum = $discountCode->discount_usages->sum('amount');
            if ($sum >= $discountCode->amount) {
                return null;
            }
        }

        if ($discountCode->mode !== 'absolute' && $discountCode->number_of_uses) {
            if ($discountCode->discount_usages->count() >= $discountCode->number_of_uses) {
                return null;
            }
        }

        return $discountCode;
    }

    public function scopeNotTooLate($builder)
    {
        return $builder->whereNull('active_until')->orWhere('active_until', '>=', now()->toDate());
    }

    public function scopeNotTooEarly($builder)
    {
        return $builder->whereNull('active_from')->orWhere('active_from', '<=', now()->toDate());
    }

    public function scopeActive($builder)
    {
        return $builder->whereNull('deactivated_at');
    }

    public function scopeUsable($builder)
    {
        return $builder->notTooLate()->notTooEarly()->active();
    }

    public function statamicMode(): Attribute
    {
        return Attribute::make(
            get: fn() => __('discount_codes.' . $this->mode),
        );
    }

    public function statamicActive(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->deactivated_at === null,
        );
    }

    public function statamicUsable(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->deactivated_at === null
                && ($this->active_until === null || $this->active_until >= now()->toDate())
                && ($this->active_from === null || $this->active_from <= now()->toDate()),
        );
    }

    public function statamicValue(): Attribute
    {
        $value = strtoupper($this->sku_number);
        if ($this->mode === 'absolute') {
            $value = NumberService::formattedFromCents($this->amount) . '&nbsp;' . config('shop.currency_sign');
        } elseif ($this->mode !== 'sku') {
            $value = $this->percent . '&nbsp;%';
        }

        return Attribute::make(
            get: fn() => $value
        );
    }

    public function statamicActiveRange(): Attribute
    {
        $range = $this->active_from ? $this->active_from->format('d.m.Y') : '?';

        $range .= '&nbsp;—&nbsp;';

        $range .= $this->active_until ? $this->active_until->format('d.m.Y') : '?';

        return Attribute::make(
            get: fn() => $range
        );
    }

    public function statamicUsages(): Attribute
    {
        return Attribute::make(
            get: fn() => [
                'allowed_usages' => $this->number_of_uses,
                'usages' => $this->discount_usages->count(),
            ]
        );
    }
}
