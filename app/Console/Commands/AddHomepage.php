<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Entry;

class AddHomepage extends Command
{
    protected $signature = 'shop:add-homepage';

    public function handle()
    {
        $entry = Entry::make()->collection('pages')->slug('home');

        $entry
            ->blueprint('page')
            ->data([
                'title' => 'Home',
                'hero_type' => 'slideshow',
                'hero_slideshow' => [
                    [
                        'id' => 'asdf675',
                        'type' => 'slide',
                        'image_phone' => 'platzhalter/rucksack-und-tasche-in-einem.jpeg',
                    ],
                ],
                'hero_disruptors' => [
                    [
                        'id' => 'dasff6df',
                        'text' => 'BENNO',
                        'type' => 'disruptor',
                        'topline' => 'neu',
                        'x_phone' => '30',
                        'y_phone' => '20',
                        'bg_color' => 'rgb(238,173,14)',
                        'link_type' => 'page',
                        'x_desktop' => '45',
                        'y_desktop' => '-10',
                    ],
                ],
                'hero_link_text' => 'Shop',
                'hero_link_type' => 'shop',
            ]);

        $entry->save();

        $this->info('done adding homepage.');
    }
}
