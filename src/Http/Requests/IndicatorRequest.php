<?php

namespace Uneca\DisseminationToolkit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicatorRequest extends FormRequest
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
            'name' => 'required|string',
            'topics' => 'required|array|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'topics.required' => 'You must select at least one topic',
        ];
    }
}
