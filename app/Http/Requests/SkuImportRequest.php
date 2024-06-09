<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkuImportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'file' => 'mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return $rules;
    }
}
