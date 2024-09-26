<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityRequest extends FormRequest
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
                return [];
            case 'POST':
                return [
                    'activity_type_id' => [
                        'required',
                        Rule::exists('activity_types','id')
                    ],
                    'opportunity_id' => [
                        'required',
                        Rule::exists('opportunities','id')
                    ],
                    'company_contact_id' => [
                        'required',
                        Rule::exists('company_contacts','id')
                    ],
                    'name' => 'required|min:2',
                    'description' => 'required|min:2',
                    'did_at' => 'required|date_format:Y-m-d H:i',
                ];
        }
    }
}
