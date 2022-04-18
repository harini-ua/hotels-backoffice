<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerProduct extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partner_product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'meal_plan_id', 'currency_id', 'partner_id', 'price', 'partner_pay_price',
        'partner_commission', 'price_filter', 'price_min', 'price_max', 'star_filter', 'star_min', 'star_max',
        'commission_min', 'nights', 'adults', 'sold_online', 'sold_retail', 'sku', 'comment',
    ];

    /**
     * Get the partner that owns the product.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the meal plan that owns the product.
     */
    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }

    /**
     * Get the currency that owns the product.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
