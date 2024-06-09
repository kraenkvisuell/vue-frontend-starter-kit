<?php

namespace App\Jobs;

use App\Imports\SkusImport;
use Illuminate\Bus\Batchable;
use App\Service\UploadService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportDiscountCodes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $files = UploadService::getNotYetImported('discount_codes');

        if (count($files)) {
            $chain = [];

            foreach ($files as $file) {
                $chain[] = new ImportDiscountCodesFile($file);
            }

            Bus::chain($chain)->dispatch();
        }
    }
}
