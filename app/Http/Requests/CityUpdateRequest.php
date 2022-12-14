<?php

namespace App\Http\Requests;

use Axiom\Rules\LocationCoordinates;
use Illuminate\Foundation\Http\FormRequest;

class CityUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'state' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'active' => 'nullable|boolean',
            'position' => [
                'nullable',
                new LocationCoordinates
            ],
            'hotels_count' => 'nullable|integer',
            'popularity' => 'nullable|integer',
            'commission' => 'nullable|integer',
        ];
    }
}
