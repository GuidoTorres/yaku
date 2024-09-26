<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SamplingRequest extends FormRequest
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
                    //USER
                    'sampling_point_id' => [
                        'required',
                        Rule::exists('sampling_points','id')
                    ],
                    'utm_zone' => 'required',
                    'north' => 'required',
                    'east' => 'required',
                    'deep_id' => [
                        'required',
                        Rule::exists('deeps','id')
                    ],
                    //'sampling_date' => 'required|date_format:Y-m-d H:i',
                    'sampling_date' => 'required',
                ];
        }
    }
}
