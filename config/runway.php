<?php

use App\Service\CpIcons;

return [

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | Configure the resources (models) you'd like to be available in Runway.
    |
    */

    'resources' => [
        \App\Models\Customer::class => [
            'name' => 'Kunden',
            'hidden' => true,
            'read_only' => true,
        ],
        \App\Models\Merchant::class => [
            'name' => 'Händler',
            'cp_icon' => CpIcons::merchants(),
            'title_field' => 'company_name',
            'read_only' => true,
        ],
        \App\Models\Order::class => [
            'name' => 'Bestellungen',
            'cp_icon' => CpIcons::orders(),
            'read_only' => true,
            'order_by' => 'order_number',
            'order_by_direction' => 'DESC',
            'title_field' => 'order_number',
            'with' => ['customer', 'skus', 'invoice_address', 'shipping_address'],
        ],
        \App\Models\ProductCategory::class => [
            'name' => 'Kategorien',
            'cp_icon' => CpIcons::categories(),
        ],
        \App\Models\DiscountCode::class => [
            'name' => 'Rabattcodes',
            'search_index' => 'discount_codes',
            'with' => ['discount_usages'],
            'order_by' => 'code',
            'cp_icon' => CpIcons::discount(),
        ],
        \App\Models\ProductTag::class => [
            'name' => 'Unterkategorien',
            'cp_icon' => CpIcons::tags(),
        ],
        \App\Models\ProductGroup::class => [
            'name' => 'Kollektionen',
            'cp_icon' => CpIcons::productGroups(),
        ],
        \App\Models\Product::class => [
            'name' => 'Modelle',
            'search_index' => 'products',
            'cp_icon' => CpIcons::products(),
        ],
        \App\Models\Sku::class => [
            'name' => 'Artikel',
            'hidden' => true,
            'read_only' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Disable Migrations?
    |--------------------------------------------------------------------------
    |
    | Should Runway's migrations be disabled?
    | (eg. not automatically run when you next vendor:publish)
    |
    */

    'disable_migrations' => false,

];
