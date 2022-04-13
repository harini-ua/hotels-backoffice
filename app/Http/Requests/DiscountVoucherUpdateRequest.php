<?php

namespace App\Http\Requests;

use App\Enums\DiscountAmountType;
use App\Enums\DiscountCodeType;
use App\Enums\DiscountCommissionType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class DiscountVoucherUpdateRequest extends FormRequest
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
            'description' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'voucher_type' => ['required', new EnumValue(DiscountCodeType::class, false)],
            'voucher_codes_count' => 'nullable|required_if:voucher_type,0|integer',
            'voucher_code' => 'nullable|required_if:voucher_type,1|string|unique:discount_voucher_codes,code',
            'currency_id' => 'nullable|exists:currencies,id',
            'amount_type' => ['required', new EnumValue(DiscountAmountType::class, false)],
            'amount' => 'required|numeric',
            'min_price' => 'required|numeric',
            'commission' => ['required', new EnumValue(DiscountCommissionType::class, false)],
            'expiry' => 'nullable|date_format:d/m/Y',
        ];
    }
}
