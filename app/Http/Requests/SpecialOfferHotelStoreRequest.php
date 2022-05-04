<?php

namespace App\Http\Requests;

use App\Enums\Rating;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class SpecialOfferHotelStoreRequest extends FormRequest
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
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'sort' => ['required', new EnumValue(Rating::class, false)],
            'hotel_id' => 'required|exists:hotels,id',
        ];
    }
}
