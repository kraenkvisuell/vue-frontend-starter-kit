<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Statamic\Facades\Entry;

class CreateDummyCategories extends Command
{
    protected $signature = 'shop:create-dummy-categories';

    public function handle()
    {
        Entry::query()->where('collection', 'product_categories')->delete();

        $count = 100000;
        for ($i = 0; $i < $count; $i++) {
            DB::table('entries')->insert([
                'collection' => 'product_categories',
                'site' => 'default',
                'status' => 'published',
                'slug' => 'test-'.$i,
                'data' => '{"title": "'.(is_int($i / 2) ? 'foo' : 'bar').'"}',
            ]);

            // $category = Entry::make()
            //     ->collection('product_categories')
            //     ->slug('test-'.$i)
            //     ->data(['title' => (is_integer($i/2) ? 'foo' : 'bar')]);

            // $category->save();
        }

        $this->info('done creating dummy categories.');
    }
}
