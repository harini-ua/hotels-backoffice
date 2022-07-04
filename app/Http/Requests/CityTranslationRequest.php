<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityTranslationRequest extends FormRequest
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
            'country_id' => 'required|exists:countries,id',
            'language_id' => 'required|exists:languages,id',
            'translations.*.country_id' => 'required|exists:countries,id',
            'translations.*.city_id' => 'required|exists:cities,id',
            'translations.*.language_id' => 'required|exists:languages,id',
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
            'country_id.required' => __('The country field is required.'),
            'language_id.required' => __('The language field is required.'),
            'translations.*.country_id.required' => __('The country field is required.'),
            'translations.*.city_id.required' => __('The city field is required.'),
            'translations.*.language_id.required' => __('The language field is required.'),
        ];
    }
}
