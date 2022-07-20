<?php

namespace App\Http\Requests;

use App\Enums\IpFilterType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IpFilterUpdateRequest extends FormRequest
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
            'type' => [ 'required', new EnumValue(IpFilterType::class, false) ],
            'ip_address' => [ 'required', 'ip', Rule::unique('ip_filter')->ignore($this->ip_filter) ],
            'comment' => 'nullable',
            'is_expiry' => 'nullable|boolean',
            'expiry' => 'nullable|required_if:is_expiry,1|date_format:d/m/Y|after:now',
        ];
    }
}
