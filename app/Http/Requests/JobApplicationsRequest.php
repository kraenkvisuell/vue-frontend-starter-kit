<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => '',
            'files' => '',
            'coverLetter' => 'required',
            'links' => '',
            'jobId' => '',
        ];

        return $rules;
    }
}
