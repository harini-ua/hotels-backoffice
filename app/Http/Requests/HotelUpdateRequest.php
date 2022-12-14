<?php

namespace App\Http\Requests;

use Axiom\Rules\LocationCoordinates;
use Illuminate\Foundation\Http\FormRequest;

class HotelUpdateRequest extends FormRequest
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
            'rating' => 'required|integer|between:1,5',
            'description' => 'required|string',
            'email' => 'nullable|email',
            'position' => [ 'nullable', new LocationCoordinates ],
            'commission' => 'nullable|number',
        ];
    }
}
