<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyContactRequest extends FormRequest
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
                return [
                    'name' => 'required|min:2',
                    'last_name' => 'required|min:2',
                    'email' => 'required|email',
                    'cellphone' => 'required|min: 5',
                    'principal' => [
                        'required',
                        Rule::in(['1', '2']),
                    ],
                    'user_owner_id' => [
                        'required',
                        Rule::exists('users','id')
                    ],
                ];
            case 'POST':
                return [
                    'name' => 'required|min:2',
                    'last_name' => 'required|min:2',
                    'email' => 'required|email',
                    'cellphone' => 'required|min: 5',
                    'principal' => [
                        'required',
                        Rule::in(['1', '2']),
                    ],
                    'company_id' => [
                        'required',
                        Rule::exists('companies','id')
                    ],
                    'user_owner_id' => [
                        'required',
                        Rule::exists('users','id')
                    ],
                ];
        }
    }
}
