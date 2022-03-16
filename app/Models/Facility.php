<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'facilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image',
    ];

    /**
     * Get the variants for the meal plan.
     */
    public function variants()
    {
        return $this->hasMany(FacilityVariant::class);
    }

    /**
     * The hotels that belong to the provider.
     */
    public function hotels()
    {
        return $this
            ->belongsToMany(Hotel::class, (new HotelFacility())->getTable())
            ->using(HotelFacility::class)
            ->withPivot((new HotelFacility())->getFillable());
    }
}
