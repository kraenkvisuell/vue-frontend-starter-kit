<?php

namespace App\Service;

use PeterColes\Countries\CountriesFacade;

class CountryService
{
    public static function options()
    {
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
    }
}
