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
            'field_id' => 'required|exists:company_fields,id',
            'company_id' => 'required|exists:companies,id',
            'language_id' => 'required|exists:languages,id',
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string',
            'translation' => 'required|string',
            'status' => 'nullable|boolean',
            'is_duplicate' => 'nullable|boolean',
        ];
    }
}
