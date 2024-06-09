<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function show($locale, $slug)
    {

        $product = Product::query()
            ->okForShop()
            ->with([
                'skus' => function ($b) {
                    $b->okForShop()
                        ->with([
                            'color_groups',
                            'colors.color_groups',
                        ]);
                },
                'product_categories',
                'product_tags',
                'product_group',
            ])->where('slug', $slug)
            ->first();

        if (! $product) {
            return abort(404);
        }

        return Inertia::render(
            'Product',
            [
                'product' => new ProductResource($product),
            ],
        );
    }
}
