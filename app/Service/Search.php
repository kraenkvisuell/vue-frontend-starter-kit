<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\SearchPageResource;
use App\Http\Resources\SearchCategoryResource;
use App\Http\Resources\SearchProductResource;
use App\Http\Resources\SearchTagResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;

class Search
{
    public function find(string $needle = ''): array
    {
        $needle = trim(strtolower($needle));

        if (strlen($needle) < 2) {
            return [];
        }

        //$needle = collect(array_map('trim', explode(' ', $needle)))->take(3);

        $allResults = [];

        if ($needle === 'shop') {
            $allResults[] = [
                'type' => 'shop',
                'results' => [[
                    'title' => 'Shop',
                    'url' => route('shop', [app()->getLocale()]),
                ]],
            ];
        }

        if ($results = $this->categories($needle)) {
            $allResults[] = $results;
        }

        if ($results = $this->tags($needle)) {
            $allResults[] = $results;
        }

        if ($results = $this->products($needle)) {
            $allResults[] = $results;
        }

        if ($results = $this->pages($needle)) {
            $allResults[] = $results;
        }

        return $allResults;
    }

    protected function products($needle)
    {
        $products = Product::search($needle)->query(function (Builder $builder) {
            $builder->with('skus')->okForShop();
        })->get();

        if ($products->count()) {
            return [
                'type' => 'products',
                'results' => SearchProductResource::collection($products),
            ];
        }

        return null;
    }

    protected function tags($needle)
    {
        $tags = ProductTag::search($needle)->query(function (Builder $builder) {
            $builder->withWhereHas('products', function ($b) {
                $b->okForShop();
            });
        })->get();

        if ($tags->count()) {
            return [
                'type' => 'tags',
                'results' => SearchTagResource::collection($tags),
            ];
        }

        return null;
    }

    protected function categories($needle)
    {
        $categories = ProductCategory::search($needle)->query(function (Builder $builder) {
            $builder->withWhereHas('products', function ($b) {
                $b->okForShop();
            });
        })->get();

        if ($categories->count()) {
            return [
                'type' => 'categories',
                'results' => SearchCategoryResource::collection($categories),
            ];
        }

        return null;
    }

    protected function pages($needle)
    {
        $pages = \Statamic\Facades\Search::in('pages', config('app.current_site'))
            ->search($needle)
            ->get()
            ->filter(fn($item) => $item->published && $item->locale === config('app.current_site'));

        if ($pages->count()) {
            return [
                'type' => 'pages',
                'results' => collect(SearchPageResource::collection($pages)->toArray(request()))->unique(),
            ];
        }

        return null;
    }
}
