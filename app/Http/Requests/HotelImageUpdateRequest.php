<?php

namespace App\Http\Requests;

use App\Models\HotelImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HotelImageUpdateRequest extends FormRequest
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
            'images.*.id' => [ 'nullable', 'sometimes', Rule::exists(HotelImage::TABLE_NAME, 'id')],
            'images.*.image' => [ 'nullable', 'sometimes', 'image',
                'mimes:'.implode(',', HotelImage::IMAGE_EXTENSIONS),
                'max:'.HotelImage::IMAGE_KILOBYTES_SIZE
            ],
            'images.*.primary' => 'nullable|boolean',
        ];
    }
}
