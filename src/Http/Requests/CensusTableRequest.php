<?php

namespace Uneca\DisseminationToolkit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CensusTableRequest extends FormRequest
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
    public function rules()
    {
        $currentDate = now()->format('Y-m-d');
        $rules = [
            'title' => 'required|min:5',
            'description' => 'nullable',
            'producer' => 'required|min:5',
            'publisher' => 'required|min:5',
            'published_date' => 'required|date|before_or_equal:' . $currentDate,
            'data_source' => 'required|min:5',
            'comment' => 'nullable',
            'topics' => 'required|array|min:1',
            'tags' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $rules['file'] = 'required|file|max:100000';
        } else {
            $rules['file'] = 'nullable|file|max:100000';
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'The title field is required',
            'producer.required' => 'The producer field is required',
            'publisher.required' => 'The publisher field is required',
            'published_date.required' => 'The published date field is required',
            'published_date.before_or_equal' => 'The published date must be a date before or equal to today',
            'data_source.required' => 'The data source field is required',
            'topics.required' => 'You must select at least one topic',
            'file.required' => 'The file field is required',
        ];
    }
}
