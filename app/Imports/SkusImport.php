<?php

namespace App\Imports;

use App\Models\Color;
use App\Models\ColorGroup;
use App\Models\Material;
use App\Models\Packaging;
use App\Models\Product;
use Statamic\Facades\Site;
use App\Models\ProductCategory;
use App\Models\ProductGroup;
use App\Models\ProductTag;
use App\Models\Sku;
use App\Models\SpecialCharacteristic;
use App\Service\DateService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Tiptap\Editor;
use Tiptap\Extensions\StarterKit;
use Tiptap\Marks\Highlight;
use Tiptap\Marks\Link;
use Tiptap\Marks\Subscript;
use Tiptap\Marks\Superscript;
use Tiptap\Marks\Underline;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableRow;

class SkusImport implements ToCollection, WithHeadingRow
{
    public $touchedCategories = [];

    public $touchedColorGroups = [];

    public $touchedColors = [];

    public $touchedGroups = [];

    public $touchedMaterials = [];

    public $touchedPackagings = [];

    public $touchedProducts = [];

    public $touchedSkus = [];

    public $touchedSpecialCharacteristics = [];

    public $touchedTags = [];

    public $secondaryLanguages;

    private function editor()
    {
        return app()->makeWith(Editor::class, [
            'configuration' => [
                'extensions' => [
                    new StarterKit(),
                    new Link(),
                    new Underline(),
                    new Subscript(),
                    new Superscript(),
                    new Highlight(),
                    new Table(),
                    new TableRow(),
                    new TableCell(),
                ],
            ],
        ]);
    }

    public function collection(Collection $collection)
    {
        ini_set('memory_limit', '4096M');
        ini_set('max_input_time', 600);
        ini_set('max_execution_time', 600);

        $this->secondaryLanguages = array_filter(
            config('translatable.languages'),
            fn($key) => $key != 'de',
            ARRAY_FILTER_USE_KEY
        );

        foreach ($collection as $row) {
            $categories = $this->createOrUpdateCategories($row);
            $tags = $this->createOrUpdateTags($row);
            $group = $this->createOrUpdateGroup($row);
            $colorGroup = $this->createOrUpdateColorGroup($row);
            $colors = $this->createOrUpdateColors($row, $colorGroup);
            $packagings = $this->createOrUpdatePackagings($row);
            $specialCharacteristics = $this->createOrUpdateSpecialCharacteristics($row);
            $material = $this->createOrUpdateMaterial($row);
            $product = $this->createOrUpdateProduct($row, $group, $categories, $tags, $material, $specialCharacteristics, $packagings);
            $this->createOrUpdateSku($row, $colors, $colorGroup, $product);
        }

        $this->removeNotIncludedSkus();
    }

    protected function createOrUpdateColors($row, $colorGroup)
    {
        $colors = [];
        $colorName = $this->getField($row, 'color');
        $colorSorter = intval($this->getField($row, 'color_sorter'));
        $secondaryColorName = $this->getField($row, 'secondary_color');
        $rgb = $this->getField($row, 'rgb');

        $secondaryRgb = $this->getField($row, 'secondary_rgb');

        if (($colorName || $rgb) && $colorGroup) {
            $color = $this->createOrUpdateColor($colorName, $rgb, $colorSorter);

            $color->color_groups()->syncWithoutDetaching($colorGroup['id']);

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

        if (isset($this->touchedColors[$slug])) {
            return $this->touchedColors[$slug];
        }

        $update = [
            'title' => $colorName,
            'rgb' => 'rgb(' . $rgb . ')',
        ];

        if ($colorSorter) {
            $update['sorter'] = $colorSorter;
        }

        $color = Color::updateOrCreate(
            ['slug' => $slug],
            $update
        );

        $this->touchedColors[$slug] = $color;

        return $color;
    }

    protected function createOrUpdateColorGroup($row)
    {
        $colorGroupName = $this->getField($row, 'color_group');

        if (!$colorGroupName) {
            return [];
        }

        $slug = Str::slug(Str::convertUmlauts($colorGroupName), '-');

        if (isset($this->touchedColorGroups[$slug])) {
            return $this->touchedColorGroups[$slug];
        }

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
        ];

        foreach ($this->secondaryLanguages as $locale => $params) {
            $titleHeader = $this->getHeaderForLocale('color_group', $locale);

            if (isset($row[$titleHeader]) && $row[$titleHeader]) {

                $translated['localized_title'][$locale] = ['value' => $row[$titleHeader]];
                $translated['localized_slug'][$locale] = ['value' => Str::slug(Str::convertUmlauts($row[$titleHeader]), '-')];
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

        return $this->touchedColorGroups[$slug] = $colorGroup;
    }

    protected function createOrUpdateMaterial($row)
    {
        $materialName = $this->getField($row, 'product_materials');

        if (!$materialName) {
            return [];
        }

        $slug = Str::slug(Str::convertUmlauts($materialName), '-');

        if (isset($this->touchedMaterials[$slug])) {
            return $this->touchedMaterials[$slug];
        }

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
        ];

        foreach ($this->secondaryLanguages as $locale => $params) {
            $titleHeader = $this->getHeaderForLocale('product_materials', $locale);

            if (isset($row[$titleHeader]) && $row[$titleHeader]) {
                $translated['localized_title'][$locale] = ['value' => $row[$titleHeader]];
                $translated['localized_slug'][$locale] = ['value' => Str::slug(Str::convertUmlauts($row[$titleHeader]), '-')];
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

        $this->touchedMaterials[$slug] = $material;

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

        if (isset($this->touchedSpecialCharacteristics[$slug])) {
            return $this->touchedSpecialCharacteristics[$slug];
        }

        $specialCharacteristic = SpecialCharacteristic::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'title' => $name,
            ]
        );

        $this->touchedSpecialCharacteristics[$slug] = $specialCharacteristic;

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

        if (isset($this->touchedPackagings[$slug])) {
            return $this->touchedPackagings[$slug];
        }

        $packaging = Packaging::updateOrCreate(
            [
                'slug' => $slug,
            ],
            [
                'title' => $name,
            ]
        );

        $this->touchedPackagings[$slug] = $packaging;

        return $packaging;
    }

    protected function createOrUpdateSku($row, $colors, $colorGroup, $product)
    {
        $header = $this->getHeader($row, 'sku_number');

        $skuName = isset($row[$header]) ? trim($row[$header]) : '';

        if (!$skuName) {
            return [];
        }

        $slug = Str::slug(Str::convertUmlauts($skuName), '-');

        if (isset($this->touchedSkus[$slug])) {
            return $this->touchedSkus[$slug];
        }

        $inMerchantPromos = $this->getField($row, 'in_merchant_promos');
        $inMerchantPromos = $inMerchantPromos ? array_map('trim', explode(',', $inMerchantPromos)) : null;

        $inExports = $this->getField($row, 'in_exports');
        $inExports = $inExports ? array_map('trim', explode(',', $inExports)) : null;

        $specialMarkers = array_map('trim', explode(',', trim($this->getField($row, 'special_markers'))));

        $specialMarkerWithoutCountries = collect($specialMarkers)->filter(function ($marker) {
            return $marker && strtolower($marker) !== 'usa';
        })->values();

        $specialMarkerWithoutCountries = count($specialMarkerWithoutCountries) ? $specialMarkerWithoutCountries : null;

        $locations = in_array('USA', $specialMarkers) ? ['us'] : null;

        $usPrice = trim($this->getField($row, 'us_price'));
        $locationPrices = $usPrice ? ['us' => intval(floatval(str_replace(',', '.', $usPrice)) * 100)] : null;

        $updateData = [
            'ean' => $this->getField($row, 'ean'),
            'product_id' => $product->id,
            'season_name' => $this->getField($row, 'season_name'),
            'is_new' => strtolower($this->getField($row, 'is_new')) == 'x',
            'show_in_pricelist' => strtolower($this->getField($row, 'show_in_pricelist')) == 'x',
            'show_in_next_pricelist' => strtolower($this->getField($row, 'show_in_next_pricelist')) == 'x',
            'title' => $skuName,
            'in_merchant_promos' => $inMerchantPromos,
            'in_exports' => $inExports,
            'locations' => $locations,
            'location_prices' => $locationPrices,
            'special_markers' => $specialMarkerWithoutCountries,
        ];

        $vatPercentage = $this->getSiteField($row, 'vat_percentage', 'default');
        if (!$vatPercentage) {
            $vatPercentage = config('shop.default_vat_percentage_per_site.default');
        }

        $priceInclVat = $this->getSiteField($row, 'price_incl_vat', 'default');
        if ($priceInclVat && config('shop.imported_price_format') == 'float') {
            $priceInclVat = intval(floatval($priceInclVat) * 100);
        }

        $discountPriceInclVat = $this->getSiteField($row, 'discount_price_incl_vat', 'default') ?: 0;
        if ($discountPriceInclVat) {
            if (config('shop.imported_price_format') == 'float') {
                $discountPriceInclVat = intval(floatval($discountPriceInclVat) * 100);
            }
        }

        $merchantPrice = $this->getSiteField($row, 'merchant_price', 'default') ?: 0;
        if ($merchantPrice && config('shop.imported_price_format') == 'float') {
            $merchantPrice = intval(floatval($merchantPrice) * 100);
        }

        $merchantAvailability = 'available';
        $merchantAvailableMonth = 0;
        $merchantAvailabilityField = $this->getSiteField($row, 'merchant_availability', 'default');
        if ($merchantAvailabilityField) {
            if (strtolower($merchantAvailabilityField) == 'ausverkauft') {
                $merchantAvailability = 'sold_out';
            } elseif (strtolower($merchantAvailabilityField) == 'unbekannt') {
                $merchantAvailability = 'unknown';
            } elseif (stristr($merchantAvailabilityField, 'nur wenige')) {
                $merchantAvailability = 'few';
            } elseif (Str::startsWith($merchantAvailabilityField, 0, 4) == 'bis ') {
                $merchantAvailability = 'maximum_date';
            } elseif (in_array($merchantAvailabilityField, DateService::germanMonthNames())) {
                $merchantAvailability = 'month_name';
                $monthNumber = array_search($merchantAvailabilityField, DateService::germanMonthNames()) + 1;
                $merchantAvailableMonth = $monthNumber;
            }

            if ($product->is_preorder) {
                $product->preorder_availability = $merchantAvailabilityField;
            }
        }

        $updateData['discount_price_incl_vat_per_site->default'] = $discountPriceInclVat;
        $updateData['is_available_per_site->default'] = $this->getSiteField($row, 'is_available', 'default') == '1';
        $updateData['is_preorder_per_site->default'] = $this->getSiteField($row, 'is_preorder', 'default') == 'x';
        $updateData['merchant_availability_per_site->default'] = $merchantAvailability;
        $updateData['preorder_availability_per_site->default'] = $merchantAvailabilityField;
        $updateData['merchant_available_month_per_site->default'] = $merchantAvailableMonth;

        $updateData['merchant_price_per_site->default'] = $merchantPrice;
        $updateData['price_incl_vat_per_site->default'] = $priceInclVat;
        $updateData['visible_for_merchants_per_site->default'] = $this->getSiteField($row, 'visible_for_merchants', 'default') == 'x';
        $updateData['visible_in_shop_per_site->default'] = $this->getSiteField($row, 'visible_in_shop', 'default') == 'x';
        $updateData['vat_percentage_per_site->default'] = $vatPercentage;

        $sku = Sku::updateOrCreate(
            [
                'slug' => $slug,
            ],
            $updateData
        );

        $sku->colors()->sync($colors->pluck('id'));

        if (isset($colorGroup['id'])) {
            $sku->color_groups()->sync([$colorGroup['id']]);
        }

        $this->touchedSkus[$slug] = $sku;

        //ImportRowImagesForSku::dispatch($sku->id, $row);

        return $sku;
    }

    protected function createOrUpdateProduct($row, $group, $categories, $tags, $material, $specialCharacteristics, $packagings)
    {
        $header = $this->getHeader($row, 'product');

        $productName = isset($row[$header]) ? trim($row[$header]) : '';

        if (!$productName) {
            return [];
        }

        $slug = Str::slug(Str::convertUmlauts($productName), '-');

        if (isset($this->touchedProducts[$slug])) {
            return $this->touchedProducts[$slug];
        }

        $translated = [
            'description' => [],
            'features' => [],
            'material_details' => [],
            'seo_text' => [],
            'seo_title' => [],
            'seo_description' => [],
            'topline' => [],
        ];

        foreach (config('translatable.languages') as $locale => $params) {
            $descriptionHeader = $this->getHeaderForLocale('product_description', $locale);

            if (isset($row[$descriptionHeader]) && $row[$descriptionHeader]) {
                $translated['description'][$locale] = ['value' => $this->bardify($row[$descriptionHeader])];
            }

            $materialDetailsHeader = $this->getHeaderForLocale('product_material_details', $locale);

            if (isset($row[$materialDetailsHeader]) && $row[$materialDetailsHeader]) {
                $translated['material_details'][$locale] = ['value' => $row[$materialDetailsHeader]];
            }

            $featuresHeader = $this->getHeaderForLocale('product_features', $locale);

            if (isset($row[$featuresHeader]) && $row[$featuresHeader]) {
                $translated['features'][$locale] = ['value' => $row[$featuresHeader]];
            }

            $seoTextHeader = $this->getHeaderForLocale('product_seo_text', $locale);

            if (isset($row[$seoTextHeader]) && $row[$seoTextHeader]) {
                $translated['seo_text'][$locale] = ['value' => $this->bardify($row[$seoTextHeader])];
            }

            $seoTitleHeader = $this->getHeaderForLocale('product_seo_title', $locale);

            if (isset($row[$seoTitleHeader]) && $row[$seoTitleHeader]) {
                $translated['seo_title'][$locale] = ['value' => $row[$seoTitleHeader]];
            }

            $seoDescriptionHeader = $this->getHeaderForLocale('product_seo_description', $locale);

            if (isset($row[$seoDescriptionHeader]) && $row[$seoDescriptionHeader]) {
                $translated['seo_description'][$locale] = ['value' => $row[$seoDescriptionHeader]];
            }

            $toplineHeader = $this->getHeaderForLocale('product_topline', $locale);

            if (isset($row[$toplineHeader]) && $row[$toplineHeader]) {
                $translated['topline'][$locale] = ['value' => $row[$toplineHeader]];
            }
        }

        $vatPercentage = $this->getField($row, 'vat_percentage');
        if (!$vatPercentage) {
            $vatPercentage = config('shop.default_vat_percentage');
        }

        $sizeGroups = null;
        if ($str = $this->getField($row, 'size_groups')) {
            $arr = explode(',', $str);
            $sizeGroups = array_map('intval', $arr);
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
                'laptop_dimensions' => $this->getField($row, 'laptop_dimensions'),
                'volume' => $this->getField($row, 'product_volume'),
                'weight' => $this->getField($row, 'product_weight'),
                'contains_magnets' => $this->getField($row, 'contains_magnets') === 'x',
                'vat_percentage' => $vatPercentage,
                'size_number' => intval($this->getField($row, 'size')),
                'bestseller_number' => $this->getField($row, 'bestseller_number'),
                'gender' => $this->getField($row, 'gender') ?: 'female',
                'size_groups' => $sizeGroups,
                'seo_text' => $translated['seo_text'],
                'seo_title' => $translated['seo_title'],
                'seo_description' => $translated['seo_description'],
                'topline' => $translated['topline'],
            ]
        );

        $product->product_categories()->sync($categories->pluck('id'));
        $product->product_tags()->sync($tags->pluck('id'));
        $product->special_characteristics()->sync($specialCharacteristics->pluck('id'));
        $product->packagings()->sync($packagings->pluck('id'));
        if (isset($material['id'])) {
            $product->materials()->sync([$material['id']]);
        }

        $this->touchedProducts[$slug] = $product;

        return $product;
    }

    protected function createOrUpdateGroup($row)
    {
        $header = $this->getHeader($row, 'product_group');
        $groupName = isset($row[$header]) ? trim($row[$header]) : '';
        $slug = Str::slug(Str::convertUmlauts($groupName), '-');

        if (isset($this->touchedGroups[$slug])) {
            return $this->touchedGroups[$slug];
        }

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
            'description' => [],
        ];

        foreach ($this->secondaryLanguages as $locale => $params) {
            $titleHeader = $this->getHeaderForLocale('product_group', $locale);

            if (isset($row[$titleHeader]) && $row[$titleHeader]) {

                $translated['localized_title'][$locale] = ['value' => $row[$titleHeader]];
                $translated['localized_slug'][$locale] = ['value' => Str::slug(Str::convertUmlauts($row[$titleHeader]), '-')];
            }
        }

        foreach (config('translatable.languages') as $locale => $params) {
            $descriptionHeader = $this->getHeaderForLocale('product_group_description', $locale);

            if (isset($row[$descriptionHeader]) && $row[$descriptionHeader]) {
                $translated['description'][$locale] = ['value' => $this->bardify($row[$descriptionHeader])];
            }

            $seoTextHeader = $this->getHeaderForLocale('product_group_seo_text', $locale);

            if (isset($row[$seoTextHeader]) && $row[$seoTextHeader]) {
                $translated['seo_text'][$locale] = ['value' => $this->bardify($row[$seoTextHeader])];
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

        $this->touchedGroups[$slug] = $productGroup;

        return $productGroup;
    }

    protected function createOrUpdateCategories($row)
    {
        $header = $this->getHeader($row, 'product_categories');

        if (!isset($row[$header]) || !$row[$header]) {
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

        if (isset($this->touchedCategories[$slug])) {
            return $this->touchedCategories[$slug];
        }

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
        ];

        foreach ($this->secondaryLanguages as $locale => $params) {
            $header = $this->getHeaderForLocale('product_categories', $locale);
            if (isset($row[$header])) {
                $categoryNames = array_map('trim', explode(',', $row[$header]));
                if (isset($categoryNames[$categoryIndex]) && $categoryNames[$categoryIndex]) {
                    $translated['localized_title'][$locale] = ['value' => $categoryNames[$categoryIndex]];
                    $translated['localized_slug'][$locale] = ['value' => Str::slug(Str::convertUmlauts($categoryNames[$categoryIndex]), '-')];
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

        $this->touchedCategories[$slug] = $productCategory;

        return $productCategory;
    }

    protected function createOrUpdateTags($row)
    {
        $header = $this->getHeader($row, 'product_tags');

        if (!isset($row[$header]) || !$row[$header]) {
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

        if (isset($this->touchedTags[$slug])) {
            return $this->touchedTags[$slug];
        }

        $translated = [
            'localized_title' => [],
            'localized_slug' => [],
        ];

        foreach ($this->secondaryLanguages as $locale => $params) {
            $header = $this->getHeaderForLocale('product_tags', $locale);
            if (isset($row[$header])) {
                $tagNames = array_map('trim', explode(',', $row[$header]));
                if (isset($tagNames[$tagIndex]) && $tagNames[$tagIndex]) {
                    $translated['localized_title'][$locale] = ['value' => $tagNames[$tagIndex]];
                    $translated['localized_slug'][$locale] = ['value' => Str::slug(Str::convertUmlauts($tagNames[$tagIndex]), '-')];
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

        $this->touchedTags[$slug] = $productTag;

        return $productTag;
    }

    protected function removeNotIncludedSkus()
    {
        $data = [];
        foreach (Site::all()->keys() as $siteKey) {
            $data['is_available_per_site'][$siteKey] = false;
            $data['visible_for_merchants_per_site'][$siteKey] = false;
            $data['visible_in_shop_per_site'][$siteKey] = false;
        }

        Sku::whereNotIn('slug', array_keys($this->touchedSkus))->update($data);
    }

    protected function getHeader($row, $configKey, $locale = 'de')
    {
        $header = Str::slug(config('shop.import_headers.' . $configKey), '_');

        if (!isset($row[$header])) {
            $header = $this->getHeaderForLocale($configKey, $locale);
        }

        return $header;
    }

    protected function getHeaderForSite($row, $configKey, $site = 'default')
    {
        $header = Str::slug(config('shop.import_headers.sites.' . $site . '.' . $configKey), '_');

        return $header;
    }

    protected function getHeaderForLocale($configKey, $locale)
    {
        return Str::slug(
            config('shop.import_headers.' . $configKey)
            . config('shop.import_locale_suffixes.' . $locale),
            '_'
        );
    }

    protected function getField($row, $field)
    {
        $header = $this->getHeader($row, $field);

        return isset($row[$header]) ? trim($row[$header]) : '';
    }

    protected function getSiteField($row, $field, $site)
    {
        $header = $this->getHeaderForSite($row, $field, $site);

        return isset($row[$header]) ? trim($row[$header]) : '';
    }

    protected function getFieldForLocale($row, $field, $locale)
    {
        $header = $this->getHeaderForLocale($field, $locale);

        return isset($row[$header]) ? trim($row[$header]) : '';
    }

    protected function bardify($str)
    {
        $obj = json_decode($this->editor()->setContent($str)->getJSON());

        return $obj->content;
    }
}
