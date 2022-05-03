<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CityCommissionUpdateRequest extends FormRequest
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
            'cities-commissions.*.city_id' => [
                'required',
//                Rule::unique('city_commission' , 'city_id'),
                Rule::exists('cities', 'id')
            ],
            'cities-commissions.*.commission' => 'required',
        ];
    }
}
