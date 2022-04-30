<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanySaleOfficeLevel2CommissionUpdateRequest extends FormRequest
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
            'level2commissions.*.sale_office_country_id' => 'required|exists:companies,id',
            'level2commissions.*.percentage' => 'required',
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
            'level2commissions.*.sale_office_country_id.required' => __('The country field is required.'),
            'level2commissions.*.percentage.required' => __('The percentage field is required.'),
        ];
    }
}
