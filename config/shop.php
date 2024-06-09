<?php

return [
    'sku_import_root' => 'Fotos',
    'sku_video_import_root' => 'Videos',
    'sku_merchant_video_import_root' => 'HaendlerVideos',
    'possible_image_perspectives' => [
        'standard',
        'open',
        'frontal',
        'right',
        'left',
        'back',
        'inside',
        'detail01',
        'detail1',
        'detail02',
        'detail2',
        'detail03',
        'detail3',
        'detail04',
        'detail4',
        'detail05',
        'detail5',
        'detail06',
        'detail6',
        'detail07',
        'detail7',
        'detail08',
        'detail8',
        'detail09',
        'detail9',
        'detail10',
        'strap',
        'other',
    ],

    'float_format' => 'de',
    'default_vat_percentage' => 19,
    'default_vat_percentage_per_site' => [
        'default' => 19,
        'suisse' => 8.1,
    ],
    'default_currency' => 'EUR',
    'default_country_iso' => 'DE',
    'currency' => env('SHOP_CURRENCY', 'EUR'),
    'currency_sign' => env('SHOP_CURRENCY_SIGN', '€'),
    'currency_signs' => [
        'default' => '€',
        'suisse' => 'CHF',
    ],
    'currencies' => [
        'default' => 'eur',
        'suisse' => 'chf',
    ],

    'imported_price_format' => 'float',
    'needs_email_verification' => false,
    'bardifies_imported_texts' => true,
    'min_sizes' => [
        's' => 0,
        'm' => 6,
        'l' => 12,
    ],

    'main_translations' => [
        'product_category_singular' => 'Produktkategorie',
        'product_category_plural' => 'Produktkategorien',
        'product_tag_singular' => 'Produkt-Tag',
        'product_tag_plural' => 'Produkt-Tags',
        'product_group_singular' => 'Kollektion',
        'product_group_plural' => 'Kollektionen',
        'product_singular' => 'Modell',
        'product_plural' => 'Modelle',
        'sku_singular' => 'Artikel',
        'sku_plural' => 'Artikel',
        'sku_number_singular' => 'Artikelnummer',
        'sku_number_plural' => 'Artikelnummern',
        'packaging_singular' => 'Verpackung',
        'packaging_plural' => 'Verpackungen',
    ],

    'import_headers' => [
        'product_categories' => '##ART_TXT_via_MODELL::##hauptkategorie',
        'product_tags' => '##ART_TXT_via_MODELL::##unterkategorie',

        'product_group' => '##kollektion_fuer_website',
        'product_group_description' => '##ART_TXT_via_KOLLEKTION::##kollektionstext',
        'product_group_seo_text' => '##ART_TXT_via_KOLLEKTION::##SEO_Text',

        'product' => '##modell',
        'product_description' => '##ART_TXT_via_MODELL::##modell_text',
        'product_features' => '##ART_TXT_via_MODELL::##modell_features',
        'product_seo_text' => '##ART_TXT_via_MODELL::SEO_TEXT',
        'product_seo_title' => '##ART_TXT_via_MODELL::META_Titel',
        'product_seo_description' => '##ART_TXT_via_MODELL::META_Description',

        'product_materials' => '##ART_TXT_via_MODELL::##material_gruppe',
        'product_topline' => '##ART_TXT_via_MODELL::##suchmaschinen_txt',
        'product_material_details' => '##ART_TXT_via_MODELL::##materialdetails',
        'product_dimensions' => '##masse_website',
        'laptop_dimensions' => '##AUTO_via_MODELL::##laptopmasse',
        'product_weight' => '##gewicht',
        'product_volume' => '##volumen_fuer_website',
        'contains_magnets' => '##AUTO_via_MODELL::##hat_magnete',
        'gender' => '##geschlecht',
        'size' => '##groessenzahl_web',
        'size_groups' => '##groessengruppe',
        'bestseller_number' => '##bestseller',

        'sku_number' => '##artikel_nr',
        'ean' => '##ean',
        'color' => '##farbe',
        'color_sorter' => '##farbsorter',
        'rgb' => '##ARTIKEL_FARBEN_via_FARBE::##rgb_werte_fuer_website',
        'secondary_rgb' => '##rgb_werte_fuer_website_sekundaer',
        'color_group' => '##farbgruppe',

        'sku_materials' => 'sku_materials',
        'sku_material_details' => 'sku_material_details',
        'sku_dimensions' => 'sku_dimensions',
        'sku_weight' => 'sku_weight',
        'sku_volume' => 'sku_volume',

        'discount_price_incl_vat' => '##rabattpreis',
        'price_incl_vat' => '##uvp_brutto',
        'price_excl_vat' => 'price_excl_vat',
        'vat_percentage' => 'vat_percentage',
        'is_available' => '##marker_im_webshop_verfuegbar',
        'merchant_price' => '##haendler_ek',
        'season_name' => '##saison',
        'is_preorder' => '##vororder',
        'visible_in_shop' => '##webshop_sichtbar',
        'visible_for_merchants' => '##b2b_shop_sichtbar',
        'is_limited_edition' => '##limited_edition',
        'is_new' => '##marker_aktuelle_neuheit',
        'is_vegan' => '##vegan',
        'is_co2_neutral' => '##co2_neutral',
        'special_markers' => '##artikelbeschraenkung',
        'misc_taxonomies1' => '##spezielle_materialien',
        'misc_taxonomies2' => '##sonderfall',
        'misc_taxonomies3' => '##marker_promoartikel',
        'in_merchant_promos' => '##marker_promoartikel',
        'in_exports' => '##productfeed',
        'fits_in_packagings' => '##AUTO_via_MODELL::##verpackung',
        'us_price' => '##usa_preis_hek_eur',
        'show_in_pricelist' => '##artikel_im_aktuellen_bestellformular',
        'show_in_next_pricelist' => '##artikel_im_naechsten_bestellformular',

        'sites' => [
            'default' => [
                'discount_price_incl_vat' => '##rabattpreis',
                'price_incl_vat' => '##uvp_brutto',
                'vat_percentage' => 'vat_percentage',
                'is_available' => '##marker_im_webshop_verfuegbar',
                'merchant_price' => '##haendler_ek',
                'is_preorder' => '##vororder',
                'visible_in_shop' => '##webshop_sichtbar',
                'visible_for_merchants' => '##b2b_shop_sichtbar',
                'merchant_availability' => '##lieferanzeige',
            ],
            'suisse' => [
                'discount_price_incl_vat' => '##rabattpreis',
                'price_incl_vat' => '##uvp_franken',
                'vat_percentage' => 'vat_percentage',
                'is_available' => '##marker_im_webshop_verfuegbar',
                'merchant_price' => '##haendler_ek_franken',
                'is_preorder' => '##vororder',
                'visible_in_shop' => '##webshop_sichtbar',
                'visible_for_merchants' => '##b2b_shop_sichtbar',
            ],
        ],
    ],

    'import_locale_suffixes' => [
        'de' => '_de',
        'en' => '_eng',
        'fr' => '_FR',
        'it' => '_IT',
        'es' => '_ES',
    ],

    'import_site_suffixes' => [
        'ch' => '_CH',
    ],

    'rename_all' => true,

    'matching_limit' => 6,
    'similar_limit' => 6,

    'matching_tag_slugs' => [
        'fahrradtasche' => ['hip-bag', 'rucksack', 'messenger-bag', 'phone-bag', 'handytasche', 'geldboerse', 'crossbag'],
        'rucksack' => ['hip-bag', 'fahrradtasche', 'phone-bag', 'handytasche', 'geldboerse', 'crossbag'],
        'geldboersen' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'hip-bag', 'hipbag'],
        'umhaengetaschen' => ['fahrradtasche', 'phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'shopper' => ['fahrradtasche', 'phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'reisetasche' => ['rucksack', 'phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'weekender' => ['phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'messenger-bag' => ['phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'phone-bag' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'hip-bag', 'hipbag'],
        'geldboerse' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'hip-bag', 'hipbag'],
        'schluesselanhaenger' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'hip-bag', 'hipbag'],
        'guerteltasche' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'hip-bag', 'hipbag'],
        'crossbag' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'hip-bag', 'hipbag'],
        'hundehalsband' => ['hundeleine'],
        'hundeleine' => ['hundehalsband'],
        'handtasche' => ['phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'mini-tasche' => ['phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'henkeltasche' => ['phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'yogatasche' => ['phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'rucksacktasche' => ['phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'handytasche' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'hip-bag', 'hipbag'],
        'geldbeutel' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'hip-bag', 'hipbag'],
        'hipbag' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'hip-bag' => ['rucksack', 'umhaengetasche', 'shopper', 'weekender', 'handtasche', 'mini-tasche', 'henkeltasche', 'rucksacktasche', 'fahrradrucksack', 'phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
        'fahrradrucksack' => ['phone-bag', 'handytasche', 'geldboerse', 'geldbeutel'],
    ],

    'xml_order_path' => env('XML_ORDER_PATH', 'xmlorder'),
    'xml_order_pending_path' => env('XML_ORDER_PENDING_PATH', 'xmlorder/pending'),
    'xml_order_processed_path' => env('XML_ORDER_PROCESSED_PATH', 'xmlorder/processed'),
    'xml_order_endpoint' => env('XML_ORDER_ENDPOINT', ''),
    'xml_order_recipient_mail' => env('XML_ORDER_RECIPIENT_MAIL', ''),
    'xml_order_view' => env('XML_ORDER_VIEW', 'xml.order'),
];
