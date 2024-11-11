<?php

namespace Uneca\DisseminationToolkit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatasetImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'datafile' => 'mimetypes:text/csv'
        ];
    }
}
