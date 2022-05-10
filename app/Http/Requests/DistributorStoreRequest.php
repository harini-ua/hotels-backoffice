<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DistributorStoreRequest extends FormRequest
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
            // Distributor user
            'phone' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:8',
            'address' => 'required|string',
            'country_ids.*' => 'required|exists:countries,id',
            'language_ids.*' => 'required|exists:languages,id',
            'company_ids.*' => 'required|exists:companies,id',
        ];
    }
}
