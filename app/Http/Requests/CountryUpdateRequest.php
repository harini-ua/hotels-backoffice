<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'region' => 'required|string',
            'code' => [ 'required', Rule::unique('countries')->ignore($this->country) ],
            'currency_id' => 'required|exists:currencies,id',
            'language_id' => 'required|exists:languages,id',
            'active' => 'nullable|bool',
        ];
    }
}
