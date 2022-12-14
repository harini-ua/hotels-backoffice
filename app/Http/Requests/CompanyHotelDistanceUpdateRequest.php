<?php

namespace App\Http\Requests;

use App\Enums\HotelDistanceFilters;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class CompanyHotelDistanceUpdateRequest extends FormRequest
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
            'distances.*.name' => ['required', new EnumValue(HotelDistanceFilters::class, false)],
        ];
    }
}
