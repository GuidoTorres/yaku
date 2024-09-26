<?php

namespace App\Http\Requests;

use App\Parameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParameterRequest extends FormRequest
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
                    'name' => 'required|min:2',
                    'description' => 'nullable',
                    'code' => 'required|min:2',
                    'unit_id' => [
                        'required',
                        Rule::exists('units','id')
                    ],
                    'data_type' =>
                        Rule::in([
                            Parameter::POSITIVE_INTEGER,
                            Parameter::NEGATIVE_INTEGER,
                            Parameter::INTEGER,
                            Parameter::POSITIVE_FLOAT,
                            Parameter::NEGATIVE_FLOAT,
                            Parameter::FLOAT,
                            Parameter::STRING,
                            Parameter::BOOLEAN,
                            Parameter::ZERO_TO_ONE_DECIMAL,
                        ])
                ];
        }
    }
}
