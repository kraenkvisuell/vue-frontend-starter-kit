<?php

namespace App\Service;

use App\Queries\ShopProducts;
use Illuminate\Support\Facades\Cache;
use Statamic\Facades\Entry;
use App\Http\Resources\ReducedProductResource;

class EntryCacheService
{
    public static function entryBySlug(string $slug, string $collection = 'pages', ?string $site = null)
    {
        $site = $site ?: config('app.current_site');
        $key = static::keyBase($site) . '.' . $collection . '.' . $slug;

        //Cache::forget($key);

        return Cache::rememberForever($key, function () use ($slug, $collection, $site) {
            $entry = Entry::query()
                ->where('collection', $collection)
                ->where('site', $site)
                ->where('slug', $slug)
                ->first();

            if (!$entry && $site != 'default') {
                $entry = Entry::query()
                    ->where('collection', $collection)
                    ->where('site', 'default')
                    ->where('slug', $slug)
                    ->first();
            }

            return $entry;
        });
    }

    public static function keyBase($site)
    {
        return 'entries_' . $site . '.' . app()->getLocale();
    }

    public static function augmentedEntry($entry)
    {

        if (!$entry) {
            return [];
        };

        $key = 'augmented_entry.' . $entry->id . '.' . app()->getLocale();

        Cache::forget($key);

        return Cache::rememberForever($key, function () use ($entry) {
            $entry = $entry->toArray();

            $entry['blocks'] = collect($entry['blocks'])->map(function ($block) {
                if ($block['type'] === 'selected_products') {
                    $products = collect([]);
                    foreach ($block['products'] ?? [] as $blockProductId) {
                        $product = (new ShopProducts)()->where('id', $blockProductId)->first();

                        if ($product) {
                            $products->push(ReducedProductResource::make($product));
                        }
                    }

                    return [
                        'type' => $block['type'],
                        'products' => $products,
                    ];
                }

                foreach ($block as $blockKey => $blockValue) {
                    $block[$blockKey] = StatamicService::recursiveAugmentedBlock($blockKey, $blockValue);
                }

                return $block;
            });

            return $entry;
        });
    }
}
