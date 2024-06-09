<?php

namespace App\Cached;

use App\Models\ProductGroup;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductGroupsResource;

class CachedShopProductGroups extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () {
            return ProductGroupsResource::collection(ProductGroup::query()
                ->withWhereHas('products', function ($b) {
                    $b->okForShop()->with(['product_categories', 'product_tags'])
                        ->withWhereHas('skus', function ($b) {
                            $b->where('visible_in_shop_per_site->' . config('app.current_site'), true);
                        });
                })
                ->get());
        });
    }

    public function key($id = null)
    {
        return 'shop_product_groups';
    }

    public function model()
    {
        return null;
    }
}
