<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FillUuids extends Command
{
    protected $signature = 'fill-uuids';

    public function handle()
    {
        $entries = DB::table('entries')->get();

        foreach ($entries as $entry) {
            DB::table('entries')
                ->where('id', $entry->id)
                ->update(['id' => Str::uuid()]);
        }
    }
}
