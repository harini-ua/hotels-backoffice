<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyOthersUpdateRequest extends FormRequest
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
            'sub_companies' => 'nullable|boolean',
            'chat_enabled' => 'nullable|boolean',
            'chat_script' => [
                Rule::requiredIf(static function () {
                    return request()->has('chat_enabled');
                }),
                'nullable',
                'string'
            ],
            'adobe_enabled' => 'nullable|boolean',
            'adobe_script' => [
                Rule::requiredIf(static function () {
                    return request()->has('adobe_enabled');
                }),
                'nullable',
                'string'
            ],
        ];
    }
}
