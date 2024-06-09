<?php

namespace App\Cached;

use App\Models\Sku;
use App\Queries\ShopSkus;
use App\Http\Resources\SkuResource;
use Illuminate\Support\Facades\Cache;

class CachedMatchingSkus extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () use ($id) {
            $builder = (new ShopSkus())();
            $builder->prioMatching($id)->limit(config('shop.matching_limit'));
            $prios = $builder->get();
            $count = $prios->count();
            if ($count >= config('shop.matching_limit')) {
                return $prios;
            }

            $builder = (new ShopSkus())();
            $builder->otherMatching($id)->limit(config('shop.matching_limit') - $count);
            $others = $builder->get();

            return SkuResource::collection($prios->merge($others));
        });
    }

    public function key($id = null)
    {
        return 'matching_skus.' . $id;
    }

    public function model()
    {
        return Sku::class;
    }
}
