<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerson extends FormRequest
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
            'survey_uuid' => 'required|uuid',
            'post_id' => 'required|integer',
            'department_id' => 'required|integer',
            'industry_id' => 'required|integer',
            'email' => 'nullable|email',
            'agree' => 'required_with:email|integer',
            'practice' => 'required|integer',
        ];
    }
}
