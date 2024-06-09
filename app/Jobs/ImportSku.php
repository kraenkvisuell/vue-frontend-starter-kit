<?php

namespace App\Jobs;

use App\Models\Color;
use App\Models\ColorGroup;
use App\Models\Material;
use App\Models\Packaging;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGroup;
use App\Models\ProductTag;
use App\Models\Sku;
use App\Models\SpecialCharacteristic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ImportSku implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $index;

    public $rows;

    public $row;

    public $secondaryLanguages;

    public function __construct($index, $rows)
    {
        $this->index = $index;
        $this->rows = $rows;
        $this->row = $this->rows[$this->index];

        $this->secondaryLanguages = array_filter(
            config('translatable.languages'),
            fn ($key) => $key != 'de',
            ARRAY_FILTER_USE_KEY
        );
    }

    public function handle()
    {
        $categories = $this->createOrUpdateCategories($this->row);
        $tags = $this->createOrUpdateTags($this->row);
        $group = $this->createOrUpdateGroup($this->row);
        $colorGroup = $this->createOrUpdateColorGroup($this->row);
        $colors = $this->createOrUpdateColors($this->row, $colorGroup);
        $packagings = $this->createOrUpdatePackagings($this->row);
        $specialCharacteristics = $this->createOrUpdateSpecialCharacteristics($this->row);
        $material = $this->createOrUpdateMaterial($this->row);
        $product = $this->createOrUpdateProduct($this->row, $group, $categories, $tags, $material, $specialCharacteristics, $packagings);
        $sku = $this->createOrUpdateSku($this->row, $colors, $colorGroup, $product);

        if ($this->index < $this->rows->count() - 1) {
            self::dispatch(($this->index + 1), $this->rows);
        }
    }

    protected function createOrUpdateColors($row, $colorGroup)
    {
        $colors = [];
        $colorName = $this->getField($row, 'color');
        $colorSorter = intval($this->getField($row, 'color_sorter'));
        $secondaryColorName = $this->getField($row, 'secondary_color');
        $rgb = $this->getField($row, 'rgb');

        $secondaryRgb = $this->getField($row, 'secondary_rgb');

        if ($colorName || $rgb) {
            $color = $this->createOrUpdateColor($colorName, $rgb, $colorSorter);

            $color->color_groups()->syncWithoutDetaching($colorGroup->id);

            $colors[] = $color;
        }

        if ($secondaryColorName || $secondaryRgb) {
            $colors[] = $this->createOrUpdateColor($secondaryColorName, $secondaryRgb);
        }

        return collect($colors);
    }

    protected function createOrUpdateColor($colorName, $rgb, $colorSorter = 0)
    {
        $colorName = $colorName ?: $rgb;

        $slug = Str::slug(Str::convertUmlauts($colorName), '-');

        $update = [
            'title' => $colorName,
            'rgb' => 'rgb('.$rgb.')',
        ];

        if ($colorSorter) {
            $update['sorter'] = $colorSorter;
        }

        $color = Color::updateOrCreate(
            ['slug' => $slug],
            $update
        );

        return $color;
    }

    protected function createOrUpdateColorGroup($row)
    {
        $colorGroupName = $this->getField($row, 'color_group');

        if (! $colorGroupName) {
            return [];
        }

        $slug = Str::slug(Str::convertUmlauts($colorGroupName), '-');

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
        ];

        foreach ($this->secondaryLanguages as $site => $params) {
            $titleHeader = $this->getHeaderForSite('color_group', $site);

            if (isset($row[$titleHeader]) && $row[$titleHeader]) {

                $translated['localized_title'][$site] = ['value' => $row[$titleHeader]];
                $translated['localized_slug'][$site] = ['value' => Str::slug(Str::convertUmlauts($row[$titleHeader]), '-')];
            }
        }

        $colorGroup = ColorGroup::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'title' => $colorGroupName,
                'localized_title' => $translated['localized_title'],
                'localized_slug' => $translated['localized_slug'],
            ]
        );

        return $colorGroup;
    }

    protected function createOrUpdateMaterial($row)
    {
        $materialName = $this->getField($row, 'product_materials');

        if (! $materialName) {
            return [];
        }

        $slug = Str::slug(Str::convertUmlauts($materialName), '-');

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
        ];

        foreach ($this->secondaryLanguages as $site => $params) {
            $titleHeader = $this->getHeaderForSite('product_materials', $site);

            if (isset($row[$titleHeader]) && $row[$titleHeader]) {
                $translated['localized_title'][$site] = ['value' => $row[$titleHeader]];
                $translated['localized_slug'][$site] = ['value' => Str::slug(Str::convertUmlauts($row[$titleHeader]), '-')];
            }
        }

        $material = Material::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'title' => $materialName,
                'localized_title' => $translated['localized_title'],
                'localized_slug' => $translated['localized_slug'],
            ]
        );

        return $material;
    }

    protected function createOrUpdateSpecialCharacteristics($row)
    {
        $characteristics = [];
        $misc1 = trim($this->getField($row, 'misc_taxonomies1'));
        $misc1Arr = $misc1 ? array_map('trim', explode(',', $misc1)) : [];

        foreach ($misc1Arr as $name) {
            $characteristics[] = $this->createOrUpdateSpecialCharacteristic(ucfirst($name));
        }

        $isVegan = $this->getField($row, 'is_vegan') == 'x';

        if ($isVegan) {
            $characteristics[] = $this->createOrUpdateSpecialCharacteristic('Vegan');
        }

        $isCo2Neutral = $this->getField($row, 'is_co2_neutral') == 'x';

        if ($isCo2Neutral) {
            $characteristics[] = $this->createOrUpdateSpecialCharacteristic('CO2-neutral');
        }

        return collect($characteristics);
    }

    protected function createOrUpdateSpecialCharacteristic($name)
    {
        $slug = Str::slug(Str::convertUmlauts($name), '-');

        $specialCharacteristic = SpecialCharacteristic::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'title' => $name,
            ]
        );

        return $specialCharacteristic;
    }

    protected function createOrUpdatePackagings($row)
    {
        $packagings = [];
        $field = trim($this->getField($row, 'fits_in_packagings'));
        $strs = $field ? array_map('trim', explode(',', $field)) : [];

        foreach ($strs as $name) {
            $packagings[] = $this->createOrUpdatePackaging($name);
        }

        return collect($packagings);
    }

    protected function createOrUpdatePackaging($name)
    {
        $slug = Str::slug(Str::convertUmlauts($name), '-');

        $packaging = Packaging::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'title' => $name,
            ]
        );

        return $packaging;
    }

    protected function createOrUpdateSku($row, $colors, $colorGroup, $product)
    {
        $header = $this->getHeader($row, 'sku_number');

        $skuName = isset($row[$header]) ? trim($row[$header]) : '';

        if (! $skuName) {
            return [];
        }

        $slug = Str::slug(Str::convertUmlauts($skuName), '-');

        $vatPercentage = $this->getField($row, 'vat_percentage');
        if (! $vatPercentage) {
            $vatPercentage = config('shop.default_vat_percentage');
        }

        $priceInclVat = $this->getField($row, 'price_incl_vat');
        if ($priceInclVat && config('shop.imported_price_format') == 'float') {
            $priceInclVat = floatval($priceInclVat) * 100;
        }

        $hasDiscountPrice = false;
        $discountPriceInclVat = $this->getField($row, 'discount_price_incl_vat') ?: 0;
        if ($discountPriceInclVat) {
            $hasDiscountPrice = true;

            if (config('shop.imported_price_format') == 'float') {
                $discountPriceInclVat = floatval($discountPriceInclVat) * 100;
            }
        }

        $merchantPrice = $this->getField($row, 'merchant_price') ?: 0;
        if ($merchantPrice && config('shop.imported_price_format') == 'float') {
            $merchantPrice = floatval($merchantPrice) * 100;
        }

        $sku = Sku::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'product_id' => $product->id,
                'title' => $skuName,
                'vat_percentage' => $vatPercentage,
                'has_discount_price' => $hasDiscountPrice,
                'is_available' => $this->getField($row, 'is_available') == '1' ? true : false,
                'visible_in_shop' => $this->getField($row, 'visible_in_shop') == 'x' ? true : false,
                'price_incl_vat' => intval($priceInclVat),
                'discount_price_incl_vat' => intval($discountPriceInclVat),
                'merchant_price' => intval($merchantPrice),
                'is_preorder' => $this->getField($row, 'is_preorder') == 'x' ? true : false,
                'visible_for_merchants' => $this->getField($row, 'visible_for_merchants') == 'x' ? true : false,
                'season_name' => $this->getField($row, 'season_name'),
                'ean' => $this->getField($row, 'ean'),
            ]
        );

        $sku->colors()->sync($colors->pluck('id'));
        if (isset($colorGroup['id'])) {
            $sku->color_groups()->sync([$colorGroup['id']]);
        }

        return $sku;
    }

    protected function createOrUpdateProduct($row, $group, $categories, $tags, $material, $specialCharacteristics, $packagings)
    {
        $header = $this->getHeader($row, 'product');

        $productName = isset($row[$header]) ? trim($row[$header]) : '';

        if (! $productName) {
            return [];
        }

        $slug = Str::slug(Str::convertUmlauts($productName), '-');

        $translated = [
            'description' => [],
            'features' => [],
            'material_details' => [],
        ];

        foreach (config('translatable.languages') as $site => $params) {
            $descriptionHeader = $this->getHeaderForSite('product_description', $site);

            if (isset($row[$descriptionHeader]) && $row[$descriptionHeader]) {
                $translated['description'][$site] = ['value' => $this->bardify($row[$descriptionHeader])];
            }

            $materialDetailsHeader = $this->getHeaderForSite('product_material_details', $site);

            if (isset($row[$materialDetailsHeader]) && $row[$materialDetailsHeader]) {
                $translated['material_details'][$site] = ['value' => $row[$materialDetailsHeader]];
            }

            $featuresHeader = $this->getHeaderForSite('product_features', $site);

            if (isset($row[$featuresHeader]) && $row[$featuresHeader]) {
                $translated['features'][$site] = ['value' => $row[$featuresHeader]];
            }
        }

        $vatPercentage = $this->getField($row, 'vat_percentage');
        if (! $vatPercentage) {
            $vatPercentage = config('shop.default_vat_percentage');
        }

        $product = Product::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'product_group_id' => $group->id,
                'title' => $productName,
                'description' => $translated['description'],
                'features' => $translated['features'],
                'material_details' => $translated['material_details'],
                'dimensions' => $this->getField($row, 'product_dimensions'),
                'volume' => $this->getField($row, 'product_volume'),
                'weight' => $this->getField($row, 'product_weight'),
                'contains_magnets' => $this->getField($row, 'contains_magnets') === 'x',
                'vat_percentage' => $vatPercentage,
            ]
        );

        $product->product_categories()->sync($categories->pluck('id'));
        $product->product_tags()->sync($tags->pluck('id'));
        $product->special_characteristics()->sync($specialCharacteristics->pluck('id'));
        $product->packagings()->sync($packagings->pluck('id'));
        if (isset($material['id'])) {
            $product->materials()->sync([$material['id']]);
        }

        return $product;
    }

    protected function createOrUpdateGroup($row)
    {
        $header = $this->getHeader($row, 'product_group');
        $groupName = isset($row[$header]) ? trim($row[$header]) : '';
        $slug = Str::slug(Str::convertUmlauts($groupName), '-');

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
            'description' => [],
        ];

        foreach ($this->secondaryLanguages as $site => $params) {
            $titleHeader = $this->getHeaderForSite('product_group', $site);

            if (isset($row[$titleHeader]) && $row[$titleHeader]) {

                $translated['localized_title'][$site] = ['value' => $row[$titleHeader]];
                $translated['localized_slug'][$site] = ['value' => Str::slug(Str::convertUmlauts($row[$titleHeader]), '-')];
            }
        }

        foreach (config('translatable.languages') as $site => $params) {
            $descriptionHeader = $this->getHeaderForSite('product_group_description', $site);

            if (isset($row[$descriptionHeader]) && $row[$descriptionHeader]) {
                $translated['description'][$site] = ['value' => $this->bardify($row[$descriptionHeader])];
            }
        }

        $productGroup = ProductGroup::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'title' => $groupName,
                'localized_title' => $translated['localized_title'],
                'localized_slug' => $translated['localized_slug'],
                'description' => $translated['description'],
            ]
        );

        return $productGroup;
    }

    protected function createOrUpdateCategories($row)
    {
        $header = $this->getHeader($row, 'product_categories');

        if (! isset($row[$header]) || ! $row[$header]) {
            return collect([]);
        }

        $categoryNames = array_map('trim', explode(',', $row[$header]));

        $categories = [];
        foreach ($categoryNames as $categoryIndex => $categoryName) {
            $categories[] = $this->createOrUpdateCategory($row, $categoryName, $categoryIndex);
        }

        return collect($categories);
    }

    protected function createOrUpdateCategory($row, $productCategoryName, $categoryIndex)
    {
        $slug = Str::slug(Str::convertUmlauts($productCategoryName), '-');

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
        ];

        foreach ($this->secondaryLanguages as $site => $params) {
            $header = $this->getHeaderForSite('product_categories', $site);
            if (isset($row[$header])) {
                $categoryNames = array_map('trim', explode(',', $row[$header]));
                if (isset($categoryNames[$categoryIndex]) && $categoryNames[$categoryIndex]) {
                    $translated['localized_title'][$site] = ['value' => $categoryNames[$categoryIndex]];
                    $translated['localized_slug'][$site] = ['value' => Str::slug(Str::convertUmlauts($categoryNames[$categoryIndex]), '-')];
                }
            }
        }

        $productCategory = ProductCategory::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'title' => $productCategoryName,
                'localized_title' => $translated['localized_title'],
                'localized_slug' => $translated['localized_slug'],
            ]
        );

        return $productCategory;
    }

    protected function createOrUpdateTags($row)
    {
        $header = $this->getHeader($row, 'product_tags');

        if (! isset($row[$header]) || ! $row[$header]) {
            return collect([]);
        }

        $tagNames = array_map('trim', explode(',', $row[$header]));

        $tags = [];
        foreach ($tagNames as $tagIndex => $tagName) {
            $tags[] = $this->createOrUpdateTag($row, $tagName, $tagIndex);
        }

        return collect($tags);
    }

    protected function createOrUpdateTag($row, $productTagName, $tagIndex)
    {
        $slug = Str::slug(Str::convertUmlauts($productTagName), '-');

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
        ];

        foreach ($this->secondaryLanguages as $site => $params) {
            $header = $this->getHeaderForSite('product_tags', $site);
            if (isset($row[$header])) {
                $tagNames = array_map('trim', explode(',', $row[$header]));
                if (isset($tagNames[$tagIndex]) && $tagNames[$tagIndex]) {
                    $translated['localized_title'][$site] = ['value' => $tagNames[$tagIndex]];
                    $translated['localized_slug'][$site] = ['value' => Str::slug(Str::convertUmlauts($tagNames[$tagIndex]), '-')];
                }
            }
        }

        $productTag = ProductTag::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'title' => $productTagName,
                'localized_title' => $translated['localized_title'],
                'localized_slug' => $translated['localized_slug'],
            ]
        );

        return $productTag;
    }

    protected function getHeader($row, $configKey, $site = 'de')
    {
        $header = Str::slug(config('shop.import_headers.'.$configKey), '_');

        if (! isset($row[$header])) {
            $header = $this->getHeaderForSite($configKey, $site);
        }

        return $header;
    }

    protected function getHeaderForSite($configKey, $site)
    {
        return Str::slug(
            config('shop.import_headers.'.$configKey)
            .config('shop.import_locale_suffixes.'.$site),
            '_'
        );
    }

    protected function getField($row, $field)
    {
        $header = $this->getHeader($row, $field);

        return isset($row[$header]) ? trim($row[$header]) : '';
    }

    protected function getFieldForSite($row, $field, $site)
    {
        $header = $this->getHeaderForSite($field, $site);

        return isset($row[$header]) ? trim($row[$header]) : '';
    }

    protected function bardify($str)
    {
        return json_encode([
            [
                'type' => 'paragraph',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => str_replace('<br>', ' ', $str),
                    ],
                ],
            ],
        ]);
    }
}
