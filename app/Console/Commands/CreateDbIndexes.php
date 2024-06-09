<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDbIndexes extends Command
{
    protected $signature = 'shop:create-db-indexes';

    public function handle()
    {
        $dataIndexes = [
            'title',
        ];

        $indexesFound = collect(DB::select('SHOW INDEXES FROM entries'))->pluck('Key_name');

        foreach ($dataIndexes as $dataIndex) {
            $indexName = 'entries_'.$dataIndex.'_index';

            if (! $indexesFound->contains($indexName)) {
                $statement = 'ALTER TABLE entries
                ADD INDEX '.$indexName.' ((
                    CAST(data->>\'$."'.$dataIndex.'"\' as CHAR(255)) COLLATE utf8mb4_bin
                )) USING BTREE;';

                DB::statement($statement);
                $this->comment('created '.$dataIndex.' index.');
            } else {
                $this->warn('index '.$dataIndex.' already exists.');
            }
        }

        $this->info('done creating db indexes.');
    }
}
