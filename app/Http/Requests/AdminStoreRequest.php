<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminStoreRequest extends FormRequest
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
            'username' => 'required|string|min:3',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users')],
            'address' => 'required|string',
            'password' => 'required|string|min:8',
        ];
    }
}
