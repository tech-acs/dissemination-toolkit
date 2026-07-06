<?php

namespace Uneca\DisseminationToolkit\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'for' => 'required|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'for' => 'applies to',
        ];
    }
}
