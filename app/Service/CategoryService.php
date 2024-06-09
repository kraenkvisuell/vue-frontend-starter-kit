<?php

namespace App\Service;

use App\Cached\CachedGlobals;
use App\Models\ProductCategory;
use Statamic\Facades\GlobalSet;

class CategoryService
{
    public static function getFromGlobal($handle)
    {
        $globalSet = GlobalSet::findByHandle('shop')->inCurrentSite();

        $global = $globalSet->toAugmentedArray()[$handle];

        $viableCategories = ProductCategory::withWhereHas('products', function ($b) {
            return $b->with('product_tags')->withWhereHas('skus');
        }
        )->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'title' => ucfirst($category->localized_title),
                    'slug' => $category->slug,
                    'seo_title' => $category->seo_title,
                    'og_title' => $category->og_title,
                    'seo_description' => $category->seo_description,
                    'og_description' => $category->og_description,
                    'description' => $category->description,
                    'og_image' => $category->og_image,
                    'twitter_card_image' => $category->twitter_card_image,
                    'tags' => $category->tags(),
                ];
            })->toArray();

        $categories = [];

        foreach ($global ?? [] as $item) {
            if ($category = collect($viableCategories)->firstWhere('id', $item['category']['id']->value())) {
                $categories[] = $category;
            }
        }
        
        return $categories;
    }
}
