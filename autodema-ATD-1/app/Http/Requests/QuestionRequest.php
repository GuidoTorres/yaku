<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
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
                    'survey_id' => [
                        'required',
                        Rule::exists('surveys','id')
                    ],
                    'name' => 'required',
                ];
            }
            case 'PUT':{
                return [
                    'name' => 'required',
                ];
            }
        }
    }
}
