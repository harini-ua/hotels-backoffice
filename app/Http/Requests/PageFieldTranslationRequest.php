<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageFieldTranslationRequest extends FormRequest
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
            'page_id' => 'required|exists:pages,id',
            'language_id' => 'required|exists:languages,id',
            'translations.*.field_id' => 'required|exists:page_fields,id',
            'translations.*.country_id' => 'nullable|exists:countries,id',
            'translations.*.name' => 'required|string',
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
