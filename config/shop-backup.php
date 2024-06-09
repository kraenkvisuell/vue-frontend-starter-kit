<?php

return [
    'default_vat_percentage' => 19,
    'default_currency' => 'EUR',
    'import_headers' => [
        'product_categories' => '##ART_TXT_via_MODELL::##gruppe_mz',
        
        'product_group' => '##kollektion_fuer_website',
        'product_group_description' => 'p##ART_TXT_via_KOLLEKTION::##kollektionstext',

        'product' => '##modell',
        'product_description' => '##ART_TXT_via_MODELL::##modell_text',
        'product_features' => '##ART_TXT_via_MODELL::##modell_features',
        
        'sku_number' => '##artikel_nr',
        'ean' => '##ean',
        'color' => '##farbe',
        'rgb' => '##ARTIKEL_FARBEN_via_FARBE::##rgb_werte_fuer_website',
        'color_group' => '##farbgruppe',
        'size' => '##groessen_zahl',
        'weight' => '##gewicht',
        'dimensions' => '##masse_website',
        'material' => '##ART_TXT_via_MODELL::##material_gruppe',
        'material_details' => '##ART_TXT_via_MODELL::##materialdetails',
        'volume' => '##volumen_fuer_website',
        'price_incl_vat' => '##uvp_brutto',
        'price_excl_vat' => 'price excl. vat',
        'vat_percentage' => 'vat percentage',
        'available' => '##marker_im_webshop_verfuegbar',
        'merchant_price' => '##haendler_ek',
        'visible_in_shop' => '##webshop_sichtbar',
        'visible_for_merchants' => '##b2b_shop_sichtbar',
        'is_limited_edition' => '##limited_edition',
        'is_new' => 'is new',
        'is_vegan' => '##vegan',
        'misc_taxonomies1' => '##spezielle_materialien',
        'misc_taxonomies2' => '##sonderfall',
        'misc_taxonomies3' => '##marker_promoartikel',
        'fits_in_packagings' => '##AUTO_via_MODELL::##verpackung',
    ],

    'import_locale_suffixes' => [
        'default' => '_de',
        'de_en' => '_eng',
        'ch_fr' => '_FR',
        'it_it' => '_IT',
        'es_es' => '_ES',
    ],

    'import_site_suffixes' => [
        'ch_de' => '_CH',
        'ch_fr' => '_CH',
    ],
];
