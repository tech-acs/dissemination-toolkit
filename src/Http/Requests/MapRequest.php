<?php

namespace Uneca\DisseminationToolkit\Http\Requests;

use Uneca\DisseminationToolkit\Rules\ValidShapefileSet;
use Illuminate\Foundation\Http\FormRequest;

class MapRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'shapefile' => [
                'required',
                new ValidShapefileSet()
            ],
            'level' => 'required'
        ];
    }
}
