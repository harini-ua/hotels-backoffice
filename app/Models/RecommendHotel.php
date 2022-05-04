<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendHotel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recommended_hotels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'city_id', 'hotel_id', 'sort'
    ];

    /**
     * Get the country that owns the popular hotel.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the popular hotel.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the hotel that owns the popular hotel.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
