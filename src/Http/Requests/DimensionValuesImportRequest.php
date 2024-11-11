<?php

namespace Uneca\DisseminationToolkit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DimensionValuesImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'datafile' => 'required|file|mimes:xlsx,xls'
        ];
    }
}
