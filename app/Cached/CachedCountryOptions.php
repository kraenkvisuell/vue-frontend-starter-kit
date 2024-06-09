<?php

namespace App\Cached;

use Illuminate\Support\Facades\Cache;
use PeterColes\Countries\CountriesFacade;

class CachedCountryOptions extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () {
            $keys = [
                'DE',
                'AT',
                'HR',
                'DK',
                'ES',
                'EE',
                'FR',
                'FI',
                'HU',
                'IT',
                'IE',
                'LU',
                'LV',
                'LT',
                'PT',
                'PL',
                'RU',
                'SE',
            ];

            $options = [];

            foreach ($keys as $key) {
                $options[] = [
                    'value' => $key,
                    'label' => CountriesFacade::countryName($key, 'de'),
                ];
            }

            return $options;
        });
    }

    public function key($id = null)
    {
        return 'country_options';
    }

    public function model()
    {
        return null;
    }
}
