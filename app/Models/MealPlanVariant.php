<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlanVariant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meal_plans_variants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meal_plans_id', 'name', 'code',
    ];

    /**
     * Get the meal plan that owns the meal plan variant.
     */
    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }
}
