<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateValue extends FormRequest
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

        //dd($this->all());

        return [
            'value' => [
                'integer', 'required',
                Rule::unique('scale_values')->where(function ($query) {
                    return $query->where('scale_id', $this->scale_id);
                })],
            'scale_id' => 'integer|required',
            'name_pl' => 'string|required',
            'name_en' => 'string|required',
        ];
    }
}
