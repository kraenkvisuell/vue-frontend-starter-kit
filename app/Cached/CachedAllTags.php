<?php

namespace App\Cached;

use App\Service\CategoryService;
use Illuminate\Support\Facades\Cache;

class CachedAllTags extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () {
            $tags = [];
            $categories = CategoryService::getFromGlobal('all_categories');
            foreach ($categories as $category) {
                $tags = array_merge($tags, $category['tags']);
            }

            $tags = collect($tags)->unique()->values()->toArray();

            return $tags;
        });
    }

    public function key($id = null)
    {
        return 'shop_tags';
    }

    public function model()
    {
        return null;
    }
}
