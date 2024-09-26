<?php

namespace App\Http\Requests;

use App\SamplingPoint;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SamplingPointRequest extends FormRequest
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
                    'utm_zone' => 'required|min:2',
                    'north' => 'required|min:2',
                    'east' => 'required|min:2',
                    'eca_id' => [
                        'required',
                        Rule::exists('ecas','id')
                    ],
                    'eca_2_id' => 'nullable',
                    'basin_id' => [
                        'required',
                        Rule::exists('basins','id')
                    ],
                    'reservoir_id' => [
                        'required',
                        Rule::exists('reservoirs','id')
                    ],
                    'zone_id' => [
                        'required',
                        Rule::exists('zones','id')
                    ],
                    'state' =>
                        Rule::in([
                            SamplingPoint::FIXED_POINT,
                            SamplingPoint::FLOAT_POINT,
                        ])
                ];
        }
    }
}
