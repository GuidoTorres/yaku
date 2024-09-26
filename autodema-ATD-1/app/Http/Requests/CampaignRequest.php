<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CampaignRequest extends FormRequest
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
            case 'POST':
            case 'PUT':
                return [
                    'name' => 'required|min:2',
                    'state' => [
                        'required',
                        Rule::in(['1', '2']),
                    ],
                    'campaign_type_id' => [
                        'required',
                        Rule::exists('campaign_types','id')
                    ],
                ];
        }
    }
}
