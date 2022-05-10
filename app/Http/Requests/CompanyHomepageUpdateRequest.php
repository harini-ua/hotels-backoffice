<?php

namespace App\Http\Requests;

use App\Enums\CarouselType;
use App\Enums\TeaserType;
use App\Models\CompanyCarouselItem;
use App\Models\DefaultContent;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class CompanyHomepageUpdateRequest extends FormRequest
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
            'theme_id' => 'required|exists:company_themes,id',

            'logo' => [ 'nullable', 'sometimes', 'image',
                'mimes:'.implode(',', DefaultContent::IMAGE_EXTENSIONS),
                'max:'.DefaultContent::IMAGE_KILOBYTES_SIZE
            ],

            'carousels.*.type' => ['required', new EnumValue(CarouselType::class, false)],
            'carousels.*.image' => [ 'nullable', 'sometimes', 'image',
                'mimes:'.implode(',', CompanyCarouselItem::IMAGE_EXTENSIONS),
                'max:'.CompanyCarouselItem::IMAGE_KILOBYTES_SIZE
            ],
            'carousels.*.text' => 'nullable|string',

            'teasers.*.type' => ['required', new EnumValue(TeaserType::class, false)],
            'teasers.*.title' => 'required|string',
            'teasers.*.text' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'carousels.*.type.required' => __('The type field is required.'),
            'carousels.*.image.required' => __('The image field is required.'),
            'carousels.*.text.required' => __('The text field is required.'),

            'teasers.*.type.required' => __('The type field is required.'),
            'teasers.*.title.required' => __('The title field is required.'),
            'teasers.*.text.required' => __('The text field is required.'),
        ];
    }
}
