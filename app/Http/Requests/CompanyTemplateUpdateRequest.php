<?php

namespace App\Http\Requests;

use App\Enums\SpaPoolFilter;
use App\Enums\SystemType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class CompanyTemplateUpdateRequest extends FormRequest
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
            'client_level' => 'required|string',
            'meal_plan_id' => 'required|exists:meal_plans,id',
            'spa_pool_filter' => ['required', new EnumValue(SpaPoolFilter::class, false)],
            'system' => ['required', new EnumValue(SystemType::class, false)],
            'language_id' => 'required|exists:languages,id',
        ];
    }
}
