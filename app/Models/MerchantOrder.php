<?php

namespace App\Models;

use App\Service\DateService;
use App\Service\NumberService;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Site;
use StatamicRadPack\Runway\Traits\HasRunwayResource;

class MerchantOrder extends BaseMerchantOrder
{
    use HasRunwayResource;

    public function scopeRunwayListing($query)
    {
        $query->withWhereHas('merchant', function ($b) {
            $b->where('site', Site::selected()->handle());
        });
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->whereNotNull('placed_at');
        });
    }

    public function xmlView()
    {
        $vat = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('default_vat_percentage'));
        $plasticCompensation = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('plastic_compensation'));
        $co2Price = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('co2_compensation'));

        $plasticCompensation = $plasticCompensation * 100;
        $co2Price = $co2Price * 100;

        $plasticCompensation = $plasticCompensation / (1 + ($vat / 100));
        $plasticCompensationTax = round(($plasticCompensation - ($plasticCompensation / (1 + ($vat / 100)))), 2);

        $co2Price = $co2Price / (1 + ($vat / 100));
        $co2PriceTax = round(($co2Price - ($co2Price / (1 + ($vat / 100)))), 2);

        $view = view(config('shop.xml_order_view'))->with([
            'order' => $this,
            'vat' => $vat,
            'isMerchant' => false,
            'createdAt' => DateService::datetimeDbToXml($this->created_at),
            'plasticCompensation' => $plasticCompensation,
            'co2Price' => $co2Price,
            'plasticCompensationTax' => $plasticCompensationTax,
            'co2PriceTax' => $co2PriceTax,
        ]);

        return $view->render();
    }

    public function co2PriceQuantity()
    {
        $quantity = 0;

        $this->skus->each(function ($sku) use (&$quantity) {
            if (! $sku->is_co2_neutral) {
                $quantity += $sku->quantity;
            }
        });

        return $quantity;
    }

    public function totalCo2Price()
    {
        $co2Price = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('co2_compensation'));
        $vat = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('default_vat_percentage'));
        $price = 0;

        if ($this->customer?->is_merchant) {
            $co2Price = $co2Price / (1 + ($vat / 100));
        }

        if ($co2Price) {
            $this->skus->each(function ($sku) use (&$price, $co2Price) {
                if (! $sku->is_co2_neutral) {
                    $price += $co2Price * $sku->quantity;
                }
            });
        }

        return $price;
    }

    public function readableCo2Price()
    {
        $vat = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('default_vat_percentage'));
        $co2Price = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('co2_compensation'));

        if ($this->customer?->is_merchant) {
            $co2Price = $co2Price / (1 + ($vat / 100));
        }

        return NumberService::stringFromFloat($co2Price, 2);
    }

    public function readableTotalCo2Price()
    {
        return NumberService::stringFromFloat($this->totalCo2Price($this->site), 2);
    }

    public function plasticCompensationQuantity()
    {
        $quantity = 0;

        $this->skus->each(function ($sku) use (&$quantity) {
            $quantity += $sku->quantity;
        });

        return $quantity;
    }

    public function totalPlasticCompensation()
    {
        $plasticCompensation = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('plastic_compensation'));
        $vat = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('default_vat_percentage'));
        $price = 0;

        if ($this->customer?->is_merchant) {
            $plasticCompensation = $plasticCompensation / (1 + ($vat / 100));
        }

        if ($plasticCompensation) {
            $this->skus->each(function ($sku) use (&$price, $plasticCompensation) {
                $price += $plasticCompensation * $sku->quantity;
            });
        }

        return $price;
    }

    public function readablePlasticCompensation()
    {
        $vat = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('default_vat_percentage'));
        $plasticCompensation = NumberService::floatFromString(GlobalSet::findByHandle('shop')->in($this->site)->get('plastic_compensation'));

        if ($this->customer?->is_merchant) {
            $plasticCompensation = $plasticCompensation / (1 + ($vat / 100));
        }

        return NumberService::stringFromFloat($plasticCompensation, 2);
    }

    public function readableTotalPlasticCompensation()
    {
        return NumberService::stringFromFloat($this->totalPlasticCompensation($this->site), 2);
    }

    public function passesForDonation()
    {
        return false;
    }
}
