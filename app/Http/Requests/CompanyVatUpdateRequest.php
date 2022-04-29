<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyVatUpdateRequest extends FormRequest
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
            'vat.*.citizen_id' => 'required|exists:countries,id',
            'vat.*.country_id' => 'required|exists:countries,id',
            'vat.*.percentage' => 'required|integer'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'vat.*.citizen_id.required' => __('The citizen field is required.'),
            'vat.*.country_id.required' => __('The country field is required.'),
            'vat.*.percentage.required' => __('The percentage field is required.'),
        ];
    }
}
