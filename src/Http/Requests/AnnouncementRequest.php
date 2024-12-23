<?php

namespace Uneca\DisseminationToolkit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',
            'recipients' => 'required',
            'body' => 'required|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'The message field is required',
            'body.max' => 'The message must not be greater than 1000 characters.'
        ];
    }
}
