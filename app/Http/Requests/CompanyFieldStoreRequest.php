<?php

namespace App\Http\Requests;

use App\Enums\FieldType;
use App\Enums\VerbalType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class CompanyFieldStoreRequest extends FormRequest
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
            'max_length' => 'required|integer',
            'type' => ['required', new EnumValue(FieldType::class, false)],
            'is_mobile' => ['required', new EnumValue(VerbalType::class, false)],
        ];
    }
}
