<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityVariant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'facilities_variants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facility_id', 'name',
    ];

    /**
     * Get the meal plan that owns the meal plan variant.
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
