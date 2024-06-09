<?php

namespace App\Models;

use App\Validators\CartAddressValidator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class BaseOrder extends Model implements Auditable
{
    protected $table = 'orders';

    use AuditableTrait;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $model->shipping_address()->create(['type' => 'shipping']);
            $model->invoice_address()->create(['type' => 'invoice']);
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function skus(): HasMany
    {
        return $this->hasMany(BaseOrderSku::class, 'order_id');
    }

    public function discount_code_usages(): HasMany
    {
        return $this->hasMany(DiscountCodeUsage::class, 'order_id');
    }

    public function voucher_usages(): HasMany
    {
        return $this->hasMany(VoucherUsage::class, 'order_id');
    }

    public function payment_kind(): BelongsTo
    {
        return $this->belongsTo(PaymentKind::class, 'payment_kind_slug', 'slug');
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

    public function totalItems()
    {
        return $this->skus->sum('quantity');
    }

    public function calculatedDiscountUsages()
    {
        $usages = [];

        foreach ($this->discount_code_usages as $discountCodeUsage) {
            $usage = [
                'id' => $discountCodeUsage->id,
                'code' => $discountCodeUsage->discount_code->code,
                'mode' => $discountCodeUsage->discount_code->mode,
                'percent' => 0,
                'amount' => 0,
            ];

            if ($discountCodeUsage->discount_code->mode === 'absolute') {
                $usage['amount'] = $discountCodeUsage->amount;
            } elseif ($discountCodeUsage->discount_code->mode === 'percent') {
                $usage['amount'] = $this->subtotalInclVat() * ($discountCodeUsage->discount_code->percent / 100);
                $usage['percent'] = $discountCodeUsage->discount_code->percent;
            } elseif ($discountCodeUsage->discount_code->mode === 'most_expensive') {
                $sku = $this->skus->sortByDesc('price_incl_vat')->sortBy('quantity')->first();
                $usage['amount'] = $sku?->price_incl_vat;
            } elseif ($discountCodeUsage->discount_code->mode === 'cheapest') {
                $sku = $this->skus->sortBy('price_incl_vat')->sortBy('quantity')->first();
                $usage['amount'] = $sku?->price_incl_vat;
            } elseif ($discountCodeUsage->discount_code->mode === 'sku') {
                $sku = $this->skus->firstWhere('slug', $discountCodeUsage->discount_code->sku_number);
                $usage['amount'] = $sku?->price_incl_vat;
            }

            $usages[] = $usage;
        }

        return $usages;
    }

    public function totalAllDiscounts()
    {
        $totalDiscount = 0;

        foreach ($this->calculatedDiscountUsages() as $usage) {
            $totalDiscount += $usage['amount'];
        }

        return $totalDiscount;
    }

    public function subtotalInclVat()
    {
        return $this->skus->sum(function ($sku) {
            $price = $sku->has_discount_price ? $sku->discount_price_incl_vat : $sku->price_incl_vat;

            return $price * $sku->quantity;
        });
    }

    public function shippingCosts()
    {
        return 0;
    }

    public function totalInclVat()
    {
        $total = $this->subtotalInclVat() + $this->shippingCosts() - $this->totalAllDiscounts();

        return max($total, 0);
    }

    public function shippingCostsVat()
    {
        return 0;
    }

    public function updateAddressesFromCustomer()
    {
        if ($latestOrder = $this->customer?->latest_order) {
            $this->update(['shipping_same_as_invoice' => $latestOrder->shipping_same_as_invoice]);

            $this->invoice_address->update([
                'first_name' => $latestOrder->invoice_address->first_name,
                'last_name' => $latestOrder->invoice_address->last_name,
                'phone' => $latestOrder->invoice_address->phone,
                'email' => $latestOrder->invoice_address->email,
                'street' => $latestOrder->invoice_address->street,
                'additional_field' => $latestOrder->invoice_address->additional_field,
                'postcode' => $latestOrder->invoice_address->postcode,
                'city' => $latestOrder->invoice_address->city,
                'country_iso' => $latestOrder->invoice_address->country_iso,
            ]);

            $this->shipping_address->update([
                'first_name' => $latestOrder->shipping_address->first_name,
                'last_name' => $latestOrder->shipping_address->last_name,
                'phone' => $latestOrder->shipping_address->phone,
                'street' => $latestOrder->shipping_address->street,
                'additional_field' => $latestOrder->shipping_address->additional_field,
                'postcode' => $latestOrder->shipping_address->postcode,
                'city' => $latestOrder->shipping_address->city,
                'country_iso' => $latestOrder->shipping_address->country_iso,
            ]);
        }
    }

    public function validateAddressForCart()
    {
        $validator = new CartAddressValidator();
        $order = $this->toArray();

        return $validator($order);
    }

    public function addressesHaveBeenUpdated()
    {
        return $this->shipping_address->updated_at > $this->shipping_address->created_at
            || $this->invoice_address->updated_at > $this->invoice_address->created_at;
    }

    public function actualShippingAddress(): Attribute
    {

        return Attribute::make(
            get: fn() => $this->shipping_same_as_invoice ? $this->invoice_address : $this->shipping_address,
        );
    }
}
