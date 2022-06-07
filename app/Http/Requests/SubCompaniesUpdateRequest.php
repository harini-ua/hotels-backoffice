<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCompaniesUpdateRequest extends FormRequest
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
            'sub-companies.*.company_name' => 'required|string',
            'sub-companies.*.commission' => 'required|integer',
            'sub-companies.*.status' => 'nullable|boolean',
        ];
    }
}
