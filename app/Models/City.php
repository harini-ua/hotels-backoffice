<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, SpatialTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'state', 'active', 'blacklisted', 'position', 'hotels_count', 'popularity', 'commission'
    ];

    /**
     * The attributes that are spatial representations.
     *
     * @var array
     */
    protected $spatialFields = [
        'position',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'country'
    ];

    /**
     * Get the hotels for the city.
     */
    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }


    /**
     * Get the country that owns the city.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * The providers that belong to the city.
     */
    public function providers()
    {
        return $this
            ->belongsToMany(Provider::class)
            ->using(CityProvider::class)
            ->withPivot((new CityProvider())->getFillable());
    }

    /**
     * The commissions that belong to the city.
     */
    public function commissions()
    {
        return $this
            ->belongsToMany(Commission::class, (new CityCommission())->getTable())
            ->using(CityCommission::class)
            ->withPivot((new CityCommission())->getFillable());
    }

    /**
     * Get the user that owns the city.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the bookings that owns the city.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
