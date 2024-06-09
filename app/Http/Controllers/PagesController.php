<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTag;
use Statamic\Facades\Entry;
use App\Models\ProductGroup;
use App\Cached\CachedGlobals;
use App\Service\StringService;
use App\Models\ProductCategory;
use App\Service\EntryCacheService;
use Facades\Statamic\CP\LivePreview;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Kraenkvisuell\StatamicHelpers\Facades\Helper;

class PagesController extends Controller
{
    public function show($locale = 'de', $slug = 'home')
    {
        if (Helper::isPreview()) {
            $entry = LivePreview::item(request()->statamicToken());
        } else {
            $entry = EntryCacheService::entryBySlug(slug: $slug);
        }

        if (!$entry) {
            return $this->tryToRedirect($locale, $slug) ?? abort(404);
        }

        $entry = EntryCacheService::augmentedEntry(entry: $entry);

        $props = [
            'entry' => $entry,
        ];

        if (collect($entry['blocks'])->where('type', 'jobs')->count()) {
            $props['jobs'] = collect(Entry::whereCollection('jobs')
                ->filter(function ($item) {
                    return (!$item->visible_from || $item->visible_from <= now()->toDateString())
                        && (!$item->visible_until || $item->visible_until >= now()->toDateString());
                })
                ->toAugmentedArray())
                ->sortBy('start_date')
                ->values();
        }

        return Inertia::render(
            Str::studly($entry['blueprint']['handle']),
            $props,
        );
    }

    protected function tryToRedirect($locale, $slug)
    {
        $redirects = (new CachedGlobals)->get()['website']['redirects'];

        if (is_array($redirects) && $redirect = collect($redirects)->firstWhere('url_part', $slug)) {
            if ($redirect['link_type']['value'] === 'page') {
                $page = Entry::find($redirect['linked_page'][0]);

                return redirect()->route('pages.show', [$locale, $page->slug, 301]);
            }

            if ($redirect['link_type']['value'] === 'product') {
                $product = Product::find($redirect['linked_product'][0]);

                return redirect()->route('products.show', [$locale, $product->slug, 301]);
            }

            if ($redirect['link_type']['value'] === 'shop') {
                if ($redirect['linked_product_tag']) {
                    $productTag = ProductTag::find($redirect['linked_product_tag'][0]);

                    if ($category = $productTag->firstCategory()) {
                        return redirect()->route('shop.tag', [$locale, $category['slug'], $productTag->slug], 301);
                    }
                }

                if ($redirect['linked_product_category']) {
                    $productCategory = ProductCategory::find($redirect['linked_product_category'][0]);

                    return redirect()->route('shop.category', [$locale, $productCategory->slug, 301]);
                }

                if ($redirect['linked_product_group']) {
                    $productGroup = ProductGroup::find($redirect['linked_product_group'][0]);

                    return redirect()->route('shop.product-group', [$locale, $productGroup->slug, 301]);
                }
            }

            if ($redirect['link_type']['value'] === 'external') {
                return redirect()->to(StringService::ensureUrl($redirect['external_url']));
            }
        }

        return null;
    }
}
