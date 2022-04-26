<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCustomerSupportUpdateRequest extends FormRequest
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
            'supports.*.country_id' => 'required|exists:countries,id',
            'supports.*.email' => 'required|email',
            'supports.*.phone' => 'required|string',
            'supports.*.work_hours' => 'required|string',
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
            'supports.*.country_id.required' => __('The country field is required.'),
            'supports.*.email.required' => __('The email field is required.'),
            'supports.*.phone.required' => __('The phone field is required.'),
            'supports.*.work_hours.required' => __('The work hours field is required.'),
        ];
    }
}
