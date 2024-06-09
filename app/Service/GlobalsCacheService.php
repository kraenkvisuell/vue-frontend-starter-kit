<?php

namespace App\Service;

use Illuminate\Support\Facades\Cache;
use Statamic\Facades\GlobalSet;

class GlobalsCacheService
{
    public static function find(string $set, string $slug, $deepValue = null, $site = null)
    {
        $site = $site ?: config('app.current_site');
        $key = static::keyBase($site).'.'.$set.'.'.$slug.'.'.($deepValue ?: 'value');
        Cache::forget($key);

        return Cache::rememberForever($key, function () use ($set, $slug, $deepValue, $site) {
            $globalSet = GlobalSet::findByHandle($set)->in($site)->toAugmentedArray();
            if (! isset($globalSet[$slug])) {
                return null;
            }

            $value = $globalSet[$slug]->value();

            if ($deepValue) {
                $deeperValues = explode('.', $deepValue);
                foreach ($deeperValues as $deeperValue) {
                    $value = $value[$deeperValue];
                }
            }

            return $value;
        });
    }

    public static function keyBase($site)
    {
        return 'globals_'.$site.'.'.app()->getLocale();
    }
}
