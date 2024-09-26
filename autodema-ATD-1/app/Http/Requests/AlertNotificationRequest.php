<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlertNotificationRequest extends FormRequest
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
            case 'PUT':
            return [];
            case 'POST':
                return [
                    'note' => 'nullable',
                    'users.*' => [
                        'required',
                        Rule::exists('users','id')
                    ],
                    'parameters.*' => [
                        'required',
                        Rule::exists('parameters','id')
                    ],
                ];
        }

    }
}
