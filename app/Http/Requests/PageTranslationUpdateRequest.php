<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageTranslationUpdateRequest extends FormRequest
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
            'field_id' => 'required|exists:page_fields,id',
            'page_id' => 'required|exists:pages,id',
            'language_id' => 'required|exists:languages,id',
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string',
            'translation' => 'required|string',
            'status' => 'nullable|boolean',
            'is_duplicate' => 'nullable|boolean',
        ];
    }
}
