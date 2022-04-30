<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanySaleOfficeLevel1CommissionUpdateRequest extends FormRequest
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
            'level1commissions.*.company_id' => 'required|exists:companies,id',
            'level1commissions.*.percentage' => 'required',
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
            'level1commissions.*.company_id.required' => __('The country field is required.'),
            'level1commissions.*.percentage.required' => __('The percentage field is required.'),
        ];
    }
}
