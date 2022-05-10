<?php

namespace App\Http\Requests;

use App\Enums\AccessCodeType;
use App\Enums\CompanyCategory;
use App\Enums\CompanyStatus;
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
            'company_name' => 'required|unique:companies,company_name|string',
            'theme_id' => 'required|exists:company_themes,id',
            'category' => ['required', new EnumValue(CompanyCategory::class, false)],
            'status' => ['required', new EnumValue(CompanyStatus::class, false)],
            'admin_id' => 'required|exists:users,id',
            'country_id' => 'required|exists:countries,id',
            'template_id' => 'required|exists:company_templates,id',
            'login_type' => ['required', new EnumValue(AccessCodeType::class, false)],
            'access_codes' => [
                Rule::requiredIf(static function () {
                    return in_array((int) request()->get('login_type'), [
                        AccessCodeType::UNIQUE,
                        AccessCodeType::FIXED,
                    ], true);
                }),
            ],
        ];
    }
}
