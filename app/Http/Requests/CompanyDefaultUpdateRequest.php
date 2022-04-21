<?php

namespace App\Http\Requests;

use App\Models\CompanyDefault;
use Illuminate\Foundation\Http\FormRequest;

class CompanyDefaultUpdateRequest extends FormRequest
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
            'logo' => [ 'required', 'image',
                'mimes:'.implode(',', CompanyDefault::IMAGE_EXTENSIONS),
                'max:'.CompanyDefault::IMAGE_KILOBYTES_SIZE
            ],
            'testimonial_heading_1' => 'required|string',
            'testimonial_heading_2' => 'required|string',
            'main_page_picture' => ['nullable', 'image',
                'mimes:'.implode(',', CompanyDefault::IMAGE_EXTENSIONS),
                'max:'.CompanyDefault::IMAGE_KILOBYTES_SIZE
            ],
            'main_page_heading_1' => 'required|string',
            'main_page_heading_2' => 'required|string',
            'main_page_heading_3' => 'required|string',
            'picture_1' => [ 'nullable', 'image',
                'mimes:'.implode(',', CompanyDefault::IMAGE_EXTENSIONS),
                'max:'.CompanyDefault::IMAGE_KILOBYTES_SIZE
            ],
            'text_picture_1' => 'required|string',
            'picture_2' => [ 'nullable', 'image',
                'mimes:'.implode(',', CompanyDefault::IMAGE_EXTENSIONS),
                'max:'.CompanyDefault::IMAGE_KILOBYTES_SIZE
            ],
            'text_picture_2' => 'required|string',
            'picture_3' => [ 'nullable', 'image',
                'mimes:'.implode(',', CompanyDefault::IMAGE_EXTENSIONS),
                'max:'.CompanyDefault::IMAGE_KILOBYTES_SIZE
            ],
            'text_picture_3' => 'required|string',
            'picture_4' => [ 'nullable', 'image',
                'mimes:'.implode(',', CompanyDefault::IMAGE_EXTENSIONS),
                'max:'.CompanyDefault::IMAGE_KILOBYTES_SIZE
            ],
            'text_picture_4' => 'required|string',
            'picture_5' => [ 'nullable', 'image',
                'mimes:'.implode(',', CompanyDefault::IMAGE_EXTENSIONS),
                'max:'.CompanyDefault::IMAGE_KILOBYTES_SIZE
            ],
            'text_picture_5' => 'required|string',
            'right_heading_1' => 'required|string',
            'right_heading_message_1' => 'required|string',
            'right_heading_2' => 'required|string',
            'right_heading_message_2' => 'required|string',
        ];
    }
}
