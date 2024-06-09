<?php

namespace App\Cached;

use App\Models\ColorGroup;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ColorGroupOptionsResource;

class CachedShopColorGroups extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () {
            return ColorGroupOptionsResource::collection(ColorGroup::query()
                ->withWhereHas('skus', function ($b) {
                    $b->where('visible_in_shop_per_site->' . config('app.current_site'), true)
                        ->with(['product.product_categories', 'product.product_tags', 'product.product_group']);
                })
                ->get());
        });
    }

    public function key($id = null)
    {
        return 'shop_color_groups';
    }

    public function model()
    {
        return null;
    }
}
