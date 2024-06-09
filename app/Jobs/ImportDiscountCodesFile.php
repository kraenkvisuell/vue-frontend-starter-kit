<?php

namespace App\Jobs;

use App\Imports\SkusImport;
use Illuminate\Bus\Batchable;
use App\Service\UploadService;
use Illuminate\Bus\Queueable;
use App\Models\UsedImportFile;
use App\Imports\DiscountCodesImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportDiscountCodesFile implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $path)
    {
    }

    public function handle()
    {
        Excel::import(new DiscountCodesImport(), $this->path, 'import_data');

        UsedImportFile::create(['type' => 'discount_codes', 'path' => $this->path]);
    }
}
