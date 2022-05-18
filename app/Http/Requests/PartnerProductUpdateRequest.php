<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerProductUpdateRequest extends FormRequest
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
            'partner_id' => 'required|exists:partners,id',
            'code' => [
                'required',
                'string',
                Rule::unique('partner_products')
                    ->ignore($this->partnerProduct)
                    ->whereNull('deleted_at')
            ],
            'meal_plan_id' => 'required|exists:meal_plans,id',
            'price' => 'required|numeric',
            'partner_pay_price' => 'nullable|numeric',
            'currency_id' => 'nullable|exists:currencies,id',
            'min_commission' => 'nullable|integer',

            'price_filter' => 'nullable|bool',
            'price_min' => 'nullable|required_if:price_filter,1|numeric',
            'price_max' => 'nullable|required_if:price_filter,1|numeric',

            'star_filter' => 'nullable|bool',
            'star_min' => 'nullable|required_if:star_filter,1|numeric',
            'star_max' => 'nullable|required_if:star_filter,1|numeric',

            'nights' => 'nullable|integer',
            'adults' => 'nullable|integer',
            'sold_online' => 'nullable|bool',
            'sold_retail' => 'nullable|bool',
            'sku' => 'nullable|string',
            'comment' => 'nullable|string',
            'include_nrf' => 'nullable|bool',
            'show_all_as_nrf' => 'nullable|bool',
        ];
    }
}
