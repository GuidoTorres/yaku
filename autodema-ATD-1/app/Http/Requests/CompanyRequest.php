<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
                    'company_name' => 'required|min:2',
                    'fanpage' => 'nullable',
                    'website' => 'nullable',
                    'email' => 'nullable',
                    'phone' => 'nullable',
                    'turn' => 'nullable',
                    'country_id.*' => [
                        'required',
                        Rule::exists('countries','id')
                    ],
                ];
        }
    }
}
