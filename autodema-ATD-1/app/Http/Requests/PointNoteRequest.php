<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PointNoteRequest extends FormRequest
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
                    'sampling_point_id' =>  'required',
                    'description' => 'required',
                    'url' => 'nullable'
                ];
            }
            case 'PUT':{
                return [
                    'sampling_point_id' =>  'required',
                    'description' => 'required',
                    'url' => 'nullable'
                ];
            }
        }
    }
}
