<?php

namespace App\Providers;

use Statamic\Statamic;
use App\Actions\Statamic\ReNotifyCustomerOfOrder;
use App\Actions\Statamic\ReProcessOrderForSite;
use App\Service\NumberService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Kraenkvisuell\ShopColor\Fieldtypes\DiscountCodeUsages;
use Statamic\Facades\Collection;
use Statamic\Facades\CP\Nav;

class AppServiceProvider extends ServiceProvider
{
    protected $fieldtypes = [
        DiscountCodeUsages::class,
    ];

    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot()
    {
        $isStatamic = Str::startsWith(request()->path(), config('statamic.cp.route') . '/');

        if ($isStatamic) {
            ReNotifyCustomerOfOrder::register();
            ReProcessOrderForSite::register();
        }

        Str::macro('convertUmlauts', function (string $value) {
            $map = [
                'Ä' => 'AE',
                'Ö' => 'OE',
                'Ü' => 'UE',
                'ä' => 'ae',
                'ö' => 'oe',
                'ü' => 'ue',
                'ß' => 'ss',
            ];

            return strtr($value, $map);
        });

        //        Nav::extend(function ($nav) {
        //            $nav->content('Collections')
        //                ->children(function () {
        //                    return Collection::all()->sortBy->title()->filter(function ($item) {
        //                        return $item->handle() !== 'skus'
        //                            && $item->handle() !== 'imported_article_files';
        //                    })->map(function ($collection) {
        //                        return Nav::item($collection->title())
        //                            ->url($collection->showUrl())
        //                            ->can('view', $collection);
        //                    });
        //                });
        //        });

        //        Collection::computed('skus', 'formatted_price_incl_vat', function ($entry, $value) {
        //            return NumberService::formattedFromCents($entry->price_incl_vat);
        //        });
        //
        //        Collection::computed('skus', 'formatted_discount_price_incl_vat', function ($entry, $value) {
        //            return NumberService::formattedFromCents(cents: $entry->discount_price_incl_vat);
        //        });
        //
        //        Collection::computed('skus', 'formatted_merchant_price', function ($entry, $value) {
        //            return NumberService::formattedFromCents($entry->merchant_price);
        //        });

        Relation::enforceMorphMap([
            'address' => 'App\Models\Address',
            'baseMerchantOrder' => 'App\Models\BaseMerchantOrder',
            'baseMerchantOrderSKu' => 'App\Models\BaseMerchantOrderSku',
            'baseOrder' => 'App\Models\BaseOrder',
            'baseOrderSku' => 'App\Models\BaseOrderSku',
            'cart' => 'App\Models\Cart',
            'customer' => 'App\Models\Customer',
            'discountCode' => 'App\Models\DiscountCode',
            'discountCodeUsage' => 'App\Models\DiscountCodeUsage',
            'jobApplication' => 'App\Models\JobApplication',
            'merchant' => 'App\Models\Merchant',
            'merchantCart' => 'App\Models\MerchantCart',
            'order' => 'App\Models\Order',
            'product' => 'App\Models\Product',
            'productCategory' => 'App\Models\ProductCategory',
            'productGroup' => 'App\Models\ProductGroup',
            'productTag' => 'App\Models\ProductTag',
            'sku' => 'App\Models\Sku',
            'user' => 'App\Models\User',
            'voucherUsage' => 'App\Models\VoucherUsage',
        ]);

        if (!$isStatamic) {
            JsonResource::withoutWrapping();

            //Model::preventLazyLoading($this->app->isLocal());
        }
    }
}
