<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestion extends FormRequest
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
            'category_id' => 'integer|required',
            'question_type_id' => 'integer|required',
            'pl' => 'string|required',
            'en' => 'string|required',
            'order' => 'integer|nullable',
            'required' => 'boolean|required',
            'surveys' => 'array|nullable',
            'surveys.*' => 'integer|nullable',
        ];
    }
}
