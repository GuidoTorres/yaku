<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EcaParameterRequest extends FormRequest
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
        switch($this->method()){
            case 'GET':
            case 'DELETE':
                return [];
            case 'PUT':
            case 'POST':
                return [
                    'eca_id' => [
                        'required',
                        Rule::exists('ecas','id')
                    ],
                    'parameter_id' => [
                        'required',
                        Rule::exists('parameters','id')
                    ],
                    'min_value' => 'nullable',
                    'max_value' => 'nullable',
                    'allowed_value' => 'nullable',
                ];
        }
    }
}
