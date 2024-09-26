<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OpportunityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
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
                    'company_contact_id' => [
                        'required',
                        Rule::exists('company_contacts','id')
                    ],
                    'opportunity_type_id' => [
                        'required',
                        Rule::exists('opportunity_types','id')
                    ],
                    'campaign_id' => [
                        'required',
                        Rule::exists('campaigns','id')
                    ],
                    'stage_id' => [
                        'required',
                        Rule::exists('stages','id')
                    ],
                    'service_types.*' => [
                        'required',
                        Rule::exists('service_types','id')
                    ],
                    'additionals.*' => [
                        'required',
                        Rule::exists('additionals','id')
                    ],
                    'budget' => 'nullable|numeric',
                    'service_price' => 'nullable|numeric',
                    'probability' => 'nullable|numeric',
                    'quotation' => 'nullable',
                    'contract' => 'nullable',
                    'work_order' => 'nullable',
                ];
            case 'POST':
                return [
                    'name' => 'required|min:2',
                    'company_id' => [
                        'required',
                        Rule::exists('companies','id')
                    ],
                    'company_contact_id' => [
                        'required',
                        Rule::exists('company_contacts','id')
                    ],
                    'opportunity_type_id' => [
                        'required',
                        Rule::exists('opportunity_types','id')
                    ],
                    'campaign_id' => [
                        'required',
                        Rule::exists('campaigns','id')
                    ],
                    'stage_id' => [
                        'required',
                        Rule::exists('stages','id')
                    ],
                    'service_types.*' => [
                        'required',
                        Rule::exists('service_types','id')
                    ],
                    'additionals.*' => [
                        'required',
                        Rule::exists('additionals','id')
                    ],
                    'budget' => 'nullable|numeric',
                    'service_price' => 'nullable|numeric',
                    'probability' => 'nullable|numeric',
                ];
        }
    }
}
