<?php

namespace App\Http\Requests;

use App\Models\Hotel;
use App\Models\HotelImage;
use Illuminate\Foundation\Http\FormRequest;

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
            'primary_image_url' => [ 'nullable', 'sometimes', 'image',
                'mimes:'.implode(',', Hotel::IMAGE_EXTENSIONS),
                'max:'.Hotel::IMAGE_KILOBYTES_SIZE
            ],
            'images.*.image' => [ 'nullable', 'sometimes', 'image',
                'mimes:'.implode(',', HotelImage::IMAGE_EXTENSIONS),
                'max:'.HotelImage::IMAGE_KILOBYTES_SIZE
            ],
        ];
    }
}
