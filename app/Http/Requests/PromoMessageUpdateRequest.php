<?php

namespace App\Http\Requests;

use App\Enums\PromoMessageStatus;
use App\Models\PromoMessage;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromoMessageUpdateRequest extends FormRequest
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
            'headline' => 'required|string',
            'content' => 'required|string',
            'logo' => [ 'nullable', 'sometimes', 'image',
                'mimes:'.implode(',', PromoMessage::IMAGE_EXTENSIONS),
                'max:'.PromoMessage::IMAGE_KILOBYTES_SIZE
            ],
            'status' => ['required', new EnumValue(PromoMessageStatus::class, false)],
            'translateable' => 'nullable|bool',
            'show_all_company' => 'nullable|bool',
            'language_id' => 'required|exists:languages,id',
            'expiry_date' => 'required|string|date_format:d/m/Y|after:now',
            'company_id' => [
                Rule::requiredIf(static function () {
                    return (int) request()->get('show_all_company') !== 1;
                }),
                'nullable',
                Rule::exists('companies', 'id')
            ]
        ];
    }
}
