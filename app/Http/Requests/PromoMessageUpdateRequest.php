<?php

namespace App\Http\Requests;

use App\Enums\PromoMessageStatus;
use App\Models\PromoMessage;
use App\Rules\HasRole;
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
            'translateable' => 'nullable|boolian',
            'show_all_company' => 'nullable|boolian',
            'language_id' => 'required|exists:languages,id',
            'creator_id' => [
                'required',
                Rule::exists('user','id'),
                new HasRole(\App\Enums\UserRole::ADMIN)
            ],
            'expiry_date' => 'required|date|after:now'
        ];
    }
}
