<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'distributor_id' => 'required|exists:distributors,id',
            'company_id' => 'required|exists:companies,id',
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'password' => 'required|string|min:8',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'address' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'language_id' => 'required|exists:languages,id',
        ];
    }
}
