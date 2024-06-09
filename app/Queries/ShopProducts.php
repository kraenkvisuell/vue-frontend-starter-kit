<?php

namespace App\Queries;

use App\Models\Product;

class ShopProducts
{
    public function __invoke()
    {
        return Product::query()
            ->okForShop()
            ->with('skus', function ($b) {
                $b->okForShop()
                    ->select([
                        'discount_price_incl_vat_per_site',
                        'id',
                        'images',
                        'is_new',
                        'price_incl_vat_per_site',
                        'product_id',
                        'slug',
                        'visible_in_shop_per_site',
                    ])
                    ->with([
                        'colors' => function ($b) {
                            $b->select([
                                'colors.id', 'colors.slug', 'colors.title', 'rgb', 'sorter',
                            ])
                                ->with([
                                    'color_groups' => function ($b) {
                                        $b->select([
                                            'color_groups.id',
                                        ]);
                                    },
                                ]);
                        },
                        'color_groups' => function ($b) {
                            $b->select([
                                'color_groups.id',
                                'color_groups.slug',
                                'color_groups.title',
                                'color_groups.localized_slug',
                                'color_groups.localized_title',
                            ]);
                        },
                    ]);
            })
            ->with([
                'product_categories' => function ($b) {
                    $b->select([
                        'product_categories.id',
                        'product_categories.slug',
                        'product_categories.title',
                        'product_categories.localized_slug',
                        'product_categories.localized_title',
                    ]);
                },
                'product_tags' => function ($b) {
                    $b->select([
                        'product_tags.id',
                        'product_tags.slug',
                        'product_tags.title',
                        'product_tags.localized_slug',
                        'product_tags.localized_title',
                    ]);
                },
                'product_group' => function ($b) {
                    $b->select([
                        'product_groups.id',
                        'product_groups.slug',
                        'product_groups.title',
                        'product_groups.localized_slug',
                        'product_groups.localized_title',
                    ]);
                },
            ]);
    }
}
