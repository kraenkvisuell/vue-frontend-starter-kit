<?php

namespace App\Service;

use Illuminate\Support\Str;
use App\Models\UsedImportFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public static function getNewestFile(string $type, bool $force = false): string
    {
        $folder = config('data_upload.folders')[$type];
        $files = array_filter(Storage::disk('import_data')->files($folder), function ($file) {
            return !Str::startsWith($file, '.');
        });

        if (!count($files)) {
            return '';
        }

        rsort($files);

        if (!$force && UsedImportFile::where('type', $type)->where('path', $files[0])->exists()) {
            return '';
        }

        return $files[0];
    }

    public static function getNotYetImported($type): array
    {
        $folder = config('data_upload.folders')[$type];
        $files = array_filter(Storage::disk('import_data')->files($folder), function ($file) use ($type) {
            return !Str::startsWith($file, '.')
                && !UsedImportFile::where('type', $type)->where('path', $file)->exists();
        });

        sort($files);

        return $files;
    }
}
