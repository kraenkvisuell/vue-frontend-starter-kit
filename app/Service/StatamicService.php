<?php

namespace App\Service;

use App\Models\Product;
use App\Models\ProductTag;
use Statamic\Facades\Entry;
use Illuminate\Support\Str;
use App\Models\ProductGroup;
use App\Models\ProductCategory;
use App\Http\Resources\ReducedProductResource;
use App\Http\Resources\ReducedProductTagResource;
use App\Http\Resources\ReducedProductGroupsResource;
use App\Http\Resources\ReducedProductCategoryResource;

class StatamicService
{
    public static function augmentGlobalSet($arr): array
    {
        $returnArr = [];

        foreach ($arr ?? [] as $blockKey => $blockValue) {
            $returnArr[$blockKey] = static::recursiveAugmentedBlock($blockKey, $blockValue);
        }

        return $returnArr;
    }

    public static function recursiveAugmentedBlock($blockKey, $blockValue)
    {

        if (Str::startsWith($blockKey, 'linked_')) {
            $id = is_array($blockValue) && count($blockValue) ? $blockValue[0] : $blockValue;

            if ($id) {
                if ($blockKey === 'linked_product_category') {
                    $category = ProductCategory::find($id) ?? new ProductCategory();
                    return ReducedProductCategoryResource::make($category);
                } elseif ($blockKey === 'linked_product_tag') {
                    $tag = ProductTag::find($id) ?? new ProductTag();
                    return ReducedProductTagResource::make($tag);
                } elseif ($blockKey === 'linked_product_group') {
                    $group = ProductGroup::find($id) ?? new ProductGroup();
                    return ReducedProductGroupsResource::make($group);
                } elseif ($blockKey === 'linked_product') {
                    $product = Product::find($id) ?? new Product();
                    return ReducedProductResource::make($product);
                } elseif ($blockKey === 'linked_page') {
                    $page = Entry::find($id) ?? new Entry();
                    return $page->toArray();
                }
            }
        }

        if (is_array($blockValue)) {
            foreach ($blockValue as $newBlockKey => $newBlockValue) {
                $blockValue[$newBlockKey] = static::recursiveAugmentedBlock($newBlockKey, $newBlockValue);
            }
        }

        if (is_string($blockValue)) {
            $blockValue = static::augmentLinks($blockValue);
        }

        return $blockValue;
    }

    public static function augmentLinks($str): string
    {
        $str = str_replace('statamic://', '', $str);

        $str = preg_replace_callback('/"entry::(.*?)"/', function ($matches) {
            $item = Entry::find($matches[1]);

            if (!$item) {
                return '';
            }

            return '"' . route($item->collection?->handle . '.show', [app()->getLocale(), $item->slug]) . '"';
        }, $str);

        return $str;
    }
}
