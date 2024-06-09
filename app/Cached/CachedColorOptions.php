<?php

namespace App\Cached;

use App\Models\Color;
use Illuminate\Support\Facades\Cache;

class CachedColorOptions extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () {
            return Color::pluck('rgb', 'slug');
        });
    }

    public function key($id = null)
    {
        return 'color_options';
    }

    public function model()
    {
        return null;
    }
}
