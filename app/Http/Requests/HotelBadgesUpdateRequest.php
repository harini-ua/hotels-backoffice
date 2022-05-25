<?php

namespace App\Http\Requests;

use App\Enums\SortNumber;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class HotelBadgesUpdateRequest extends FormRequest
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
            'priority_rating' => ['nullable', new EnumValue(SortNumber::class, false)],
            'recommended' => ['nullable', new EnumValue(SortNumber::class, false)],
            'other_rating' => ['nullable', new EnumValue(SortNumber::class, false)],
            'special_offer' => 'nullable|numeric',
            'commission' => 'nullable|integer',
            'blacklisted' => 'nullable|boolean',
        ];
    }
}
