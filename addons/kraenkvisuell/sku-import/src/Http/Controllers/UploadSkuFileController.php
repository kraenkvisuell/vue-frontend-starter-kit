<?php

namespace Kraenkvisuell\SkuImport\Http\Controllers;

use Kraenkvisuell\SkuImport\Imports\SubsidiarySkusImport;
use Maatwebsite\Excel\Facades\Excel;

class UploadSkuFileController
{
    public function store()
    {
        $site = session()->get('statamic.cp.selected-site') ?? 'default';

        $import = new SubsidiarySkusImport($site);
        Excel::import($import, request()->file);

        return [
            'rowCount' => $import->getRowCount(),
            'hasErrors' => $import->getHasErrors(),
            'errorMessage' => $import->getErrorMessage(),
        ];

    }
}
