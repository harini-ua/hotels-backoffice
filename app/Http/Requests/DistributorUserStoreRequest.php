<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DistributorUserStoreRequest extends FormRequest
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
            'distributor' => 'required|exists:distributors,id',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'address' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:8',
        ];
    }
}
