<?php

namespace App\Http\Requests;

use App\Enums\NewsletterUserType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsletterExportRequest extends FormRequest
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
            'type' => ['required', new EnumValue(NewsletterUserType::class, false)],
            'company_id' => [
                Rule::requiredIf(static function () {
                    return in_array((int) request()->get('type'), [
                        NewsletterUserType::CompanySiteClient,
                        NewsletterUserType::BookingUsers
                    ], true);
                }),
                'nullable',
                Rule::exists('companies', 'id')
            ],
            'registered_date_from' => 'date_format:m/d/Y|before:today',
        ];
    }
}
