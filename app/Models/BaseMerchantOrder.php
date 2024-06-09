<?php

namespace App\Models;

use App\Service\NumberService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Statamic\Facades\GlobalSet;

class BaseMerchantOrder extends Model implements Auditable
{
    protected $table = 'merchant_orders';

    use AuditableTrait;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function defaultVatPercentage()
    {
        return once(function () {
            return NumberService::floatFromString(
                GlobalSet::findByHandle('shop')->in($this->merchant->site ?: 'default')->get('default_vat_percentage')
            );
        });
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function skus(): HasMany
    {
        return $this->hasMany(BaseMerchantOrderSku::class, 'merchant_order_id');
    }

    public function totalItems()
    {
        return $this->skus->sum('quantity');
    }

    public function skuTotal()
    {
        return $this->skus->sum(function ($sku) {
            return $sku->price * $sku->quantity;
        });
    }

    public function discount()
    {
        if ($this->merchant->discount_percentage) {
            return $this->skus->sum(function ($sku) {
                return $sku->discountSum();
            });
        }

        return 0;
    }

    public function skuTotalWithDiscount()
    {
        if ($this->discount()) {
            return $this->skuTotal() - $this->discount();
        }

        return $this->skuTotal();
    }

    public function shippingCosts()
    {
        if ($this->merchant->shipping) {
            return $this->skuTotalWithDiscount() < $this->merchant->free_limit ? $this->merchant->shipping : 0;
        }

        return 0;
    }

    public function shippingCostsVat()
    {
        return $this->shippingCosts() * ($this->defaultVatPercentage() / 100);
    }

    public function skusVat()
    {
        return $this->skus->sum(function ($sku) {
            return $sku->sumVat();
        });
    }

    public function totalVat()
    {
        return $this->shippingCostsVat() + $this->skusVat();
    }

    public function total()
    {
        return intval($this->skuTotalWithDiscount() + $this->shippingCosts() + $this->totalVat());
    }

    public function ordersForChild()
    {
        return false;
    }

    public function totalCo2Price()
    {
        return 0;
    }

    public function co2PriceQuantity()
    {
        return 0;
    }

    public function totalPlasticCompensation()
    {
        return 0;
    }

    public function plasticCompensationQuantity()
    {
        return 0;
    }
}
