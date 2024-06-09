<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class StatamicTestSeeder extends Seeder
{
    public function run()
    {
        DB::insert(
            'insert into global_sets (handle, title, settings) values (?, ?, ?)', ['mails', 'E-mails', '[]']
        );

        DB::insert(
            'insert into global_set_variables (handle, locale, data) values (?, ?, ?)',
            ['mails', 'default', '{"internal_order_recipients": "foo@bar.io, bar@foo.io"}']
        );

        DB::insert(
            'insert into global_sets (handle, title, settings) values (?, ?, ?)', ['shop', 'Shop', '[]']
        );

        ProductCategory::create([
            'id' => 1,
            'slug' => 'test',
            'title' => 'test',
        ]);


        DB::insert(
            'insert into global_set_variables (handle, locale, data) values (?, ?, ?)',
            ['shop', 'default', '{"all_categories": [{"id": "lv2dy172", "type": "category", "enabled": true, "category": 1}],"main_categories": [{"id": "dy172lv2", "type": "category", "enabled": true, "category": 1}]}']
        );

        DB::insert(
            'insert into global_sets (handle, title, settings) values (?, ?, ?)', ['website', 'Shop', '[]']
        );

        DB::insert(
            'insert into global_sets (handle, title, settings) values (?, ?, ?)', ['legal', 'Shop', '[]']
        );

        DB::insert(
            'insert into global_sets (handle, title, settings) values (?, ?, ?)', ['merchants', 'Shop', '[]']
        );

        DB::insert(
            'insert into global_sets (handle, title, settings) values (?, ?, ?)', ['jobs', 'Jobs', '[]']
        );

        DB::insert(
            'insert into collections (handle, title, settings) values (?, ?, ?)',
            [
                'pages',
                'Seiten',
                '{"dated": false, "mount": null, "sites": ["default", "suisse"], "slugs": true, "inject": [], "layout": "layout", "routes": "/de/{slug}", "sort_dir": "asc", "template": "default", "propagate": true, "revisions": false, "structure": null, "sort_field": null, "taxonomies": [], "search_index": "pages", "title_formats": [], "default_status": true, "origin_behavior": "select", "preview_targets": [{"id": "PC3Sy42h", "label": "Entry", "format": "{permalink}", "refresh": true}], "past_date_behavior": "public", "future_date_behavior": "public"}',
            ]
        );

        $pages = [
            [Str::uuid(), 'default', 1, 'home', '/de/home', 'pages', 'page', '{"title": "Home"}'],
            [Str::uuid(), 'default', 1, 'test', '/de/test', 'pages', 'page', '{"title": "Test-Seite"}'],
        ];

        foreach ($pages as $page) {
            DB::insert(
                'insert into entries (id, site, published, slug, uri, collection, blueprint, data) values (?, ?, ?, ?, ?, ?, ?, ?)',
                $page
            );
        }


    }
}
