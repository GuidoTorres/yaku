<?php

namespace App\Http\Requests;

use App\Survey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SurveyRequest extends FormRequest
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
            case 'POST':{
                return [
                    'name' => 'required',
                    'state' =>
                        Rule::in([
                            Survey::ACTIVE,
                            Survey::INACTIVE,
                        ])
                ];
            }
        }
    }
}
