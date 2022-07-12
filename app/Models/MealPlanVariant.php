<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlanVariant extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'meal_plans_variants';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

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
