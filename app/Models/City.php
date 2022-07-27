<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, SpatialTrait;

    public const TABLE_NAME = 'cities';

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
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return self::TABLE_NAME;
    }

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return !$this->blacklisted;
    }

    /**
     *  Retrieve of the models searchable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function makeAllSearchableUsing($query)
    {
        return $query->with([
            'country',
        ]);
    }

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
