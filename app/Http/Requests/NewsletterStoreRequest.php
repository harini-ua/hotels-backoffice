<?php

namespace App\Http\Requests;

use App\Enums\NewsletterUserType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsletterStoreRequest extends FormRequest
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
            'action' => 'required',
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
            'registered_date_from' => 'nullable|date_format:m/d/Y|before:today',
            'from' => [
                Rule::requiredIf(static function () {
                    return request()->get('action') === 'send';
                }),
                'email'
            ],
            'subject' => [
                Rule::requiredIf(static function () {
                    return request()->get('action') === 'send';
                }),
                'nullable'
            ],
            'message' => [
                Rule::requiredIf(static function () {
                    return request()->get('action') === 'send';
                }),
                'nullable'
            ],
        ];
    }
}
