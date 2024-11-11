<?php

namespace Uneca\DisseminationToolkit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoryRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required|min:20',
            'topics' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'topics.required' => 'You must select at least one topic.',
        ];
    }
}
