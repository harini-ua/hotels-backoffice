<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryCommissionUpdateRequest extends FormRequest
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
        return [
            'countries-commissions.*.country_id' => [
                'required',
//                Rule::unique('country_commission' , 'company_id'),
                Rule::exists('countries', 'id')
            ],
            'countries-commissions.*.commission' => 'required',
        ];
    }
}
