<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyFieldTranslationRequest extends FormRequest
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
            'company_id' => 'required|exists:companies,id',
            'language_id' => 'required|exists:languages,id',
            'translations.*.field_id' => 'required|exists:company_fields,id',
            'translations.*.country_id' => 'nullable|exists:countries,id',
            'translations.*.name' => 'nullable|string',
            'translations.*.translation' => 'nullable|string',
            'translations.*.status' => 'nullable|boolean',
            'translations.*.is_duplicate' => 'nullable|boolean',
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
            'translations.*.field_id.required' => __('The field is required.'),
        ];
    }
}
