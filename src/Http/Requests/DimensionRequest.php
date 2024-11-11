<?php

namespace Uneca\DisseminationToolkit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DimensionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[A-Za-z ]+$/',
            //'table_name' => 'required|alpha_dash:ascii|lowercase',
            'for' => 'required|min:1'
        ];
    }

    public function attributes()
    {
        return [
            'for' => 'applies to'
        ];
    }
}
