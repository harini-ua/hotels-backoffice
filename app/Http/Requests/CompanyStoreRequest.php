<?php

namespace App\Http\Requests;

use App\Enums\AccessCodeType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyStoreRequest extends FormRequest
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
            'company_name' => 'required|string',
            'login_type' => ['required', new EnumValue(AccessCodeType::class, false)],
            'access_codes' => [
                Rule::requiredIf(static function () {
                    return in_array((int) request()->get('login_type'), [
                        AccessCodeType::UNIQUE,
                        AccessCodeType::FIXED,
                    ], true);
                }),
            ]
        ];
    }
}
