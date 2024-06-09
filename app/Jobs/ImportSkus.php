<?php

namespace App\Jobs;

use App\Imports\SkusImport;
use App\Service\UploadService;
use Illuminate\Bus\Queueable;
use App\Models\UsedImportFile;
use App\Actions\ClearAllShopCaches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportSkus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $newestFile = UploadService::getNewestFile('skus');

        if ($newestFile) {
            Excel::import(new SkusImport, $newestFile, 'import_data');

            (new ClearAllShopCaches)();

            UsedImportFile::create(['type' => 'skus', 'path' => $newestFile]);
        }
    }
}
