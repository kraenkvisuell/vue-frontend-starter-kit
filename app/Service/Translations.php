<?php

namespace App\Service;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Translations
{
    public function all()
    {
        $arr = [];

        $defaultLocale = 'en';

        $folderLocale = Storage::disk('lang')->exists(app()->getLocale()) ? app()->getLocale() : $defaultLocale;

        collect(Storage::disk('lang')->files('de'))->map(function ($path) use (&$arr) {
            $file = Str::before(Str::after($path, 'de/'), '.php');

            //            if (Storage::disk('lang')->exists(app()->getLocale().'/'.$file.'.php')) {
            //
            //            }

            $arr[$file] = [];
            foreach (__($file) as $key => $value) {
                $arr[$file][$key] = $value;
            }
        });

        return $arr;
    }

    public function cachedAll()
    {
        Cache::forget('all_translations.'.app()->getLocale());

        return Cache::rememberForever('all_translations.'.app()->getLocale(), function () {
            return $this->all();
        });
    }
}
