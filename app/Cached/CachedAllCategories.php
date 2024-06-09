<?php

namespace App\Cached;

use App\Service\CategoryService;
use Illuminate\Support\Facades\Cache;

class CachedAllCategories extends Cached
{
    public function get($id = null)
    {
        //$this->clear();
        
        return Cache::rememberForever($this->extendedKey($id), function () {
            return CategoryService::getFromGlobal('all_categories');
        });
    }

    public function key($id = null)
    {
        return 'shop_categories';
    }

    public function model()
    {
        return null;
    }
}
