<?php

namespace App\View\Components;

use App\Cached\CachedAllTags;
use Statamic\Facades\Taxonomy;
use App\Cached\CachedColorOptions;
use App\Cached\CachedCountryOptions;
use App\Cached\CachedGlobals;
use App\Cached\CachedNavigations;
use App\Cached\CachedAllCategories;
use Illuminate\View\Component;
use App\Cached\CachedMainCategories;
use App\Cached\CachedShopProductGroups;
use App\Cached\CachedCookieConsentGroups;

class Shared extends Component
{
    public $shared = [];

    public function __construct()
    {
        $globals = (new CachedGlobals)->get();

        $this->shared = [
            'globals' => $globals,
            'cookieConsentGroups' => (new CachedCookieConsentGroups)->get(),
            'hasConsentedTo' => session('has_consented_to') ?: [],
            'categories' => (new CachedAllCategories)->get(),
            'tags' => (new CachedAllTags)->get(),
            'productGroups' => (new CachedShopProductGroups)->get(),
            'colorOptions' => (new CachedColorOptions)->get(),
            'countryOptions' => (new CachedCountryOptions)->get(),
            'currencySign' => config('shop.currency_signs')[config('app.current_site')],
            'currentSite' => config('app.current_site'),
            'defaultBgColor' => '#292C28',
            'flashMessages' => session('flashMessages') ?: [],
            'imgCdnUrl' => 'https://spaces.zwei-bags.com/shop/',
            'locale' => app()->getLocale(),
            'mainCategories' => (new CachedMainCategories)->get(),
            'moneyFormat' => 'de',
            'moneyLocale' => 'de',
            'nav' => (new CachedNavigations())->get(),
            'optimizedImgUrl' => 'optimized-images',
            'websiteName' => config('app.name'),
            'twicpicUrls' => [
                'articles' => 'https://zwei-bags.twic.pics/img/shop/articles',
                'assets' => 'https://zwei-bags.twic.pics/img/shop/assets',
                'articles-videos' => 'https://zwei-bags.twic.pics/video/shop/articles',
                'assets-videos' => 'https://zwei-bags.twic.pics/video/shop/assets',
            ],
            'imagekitUrl' => [
                'articles' => 'https://ik.imagekit.io/kraenk/zwei-v2-articles',
                'assets' => 'https://ik.imagekit.io/kraenk/zwei-v2-assets',
            ],

            'languages' => collect(config('translatable.languages'))->map(function ($language, $key) {
                return [
                    'key' => $key,
                    'title' => $language['local_name'],
                ];
            })->values(),
        ];
    }

    public function render()
    {
        return view('components.shared');
    }
}
