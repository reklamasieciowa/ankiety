<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSurvey extends FormRequest
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
            'finished' => 'integer|required',
            'name_pl' => 'string|required',
            'description_pl' => 'required',
            'name_en' => 'string|required',
            'description_en' => 'required',
            'company_id' => 'integer|nullable',
        ];
    }
}
