<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            case 'POST':{
                return [
                    'role_id' => [
                        'required',
                        Rule::exists('roles','id')
                    ],
                    'name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email',
                    'cellphone' => 'required|min:3',
                    'password' => 'required',
                    'state' =>
                        Rule::in([
                            User::ACTIVE,
                            User::INACTIVE,
                        ])
                ];
            }
            case 'PUT':{
                return [
                    'role_id' => [
                        'required',
                        Rule::exists('roles','id')
                    ],
                    'name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email',
                    'cellphone' => 'required|min:3',
                    'password' => 'nullable',
                    'state' =>
                        Rule::in([
                            User::ACTIVE,
                            User::INACTIVE,
                        ])
                ];
            }
        }
    }
}
