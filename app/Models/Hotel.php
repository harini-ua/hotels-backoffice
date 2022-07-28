<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Hotel extends Model
{
    use HasFactory, Searchable, SpatialTrait;

    public const TABLE_NAME = 'hotels';

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
        'city_id', 'city_code', 'city_name', 'country_id', 'country_code', 'country_name', 'status', 'blacklisted',
        'rating', 'priority_rating', 'popularity', 'recommended', 'special_offer', 'other_rating', 'commission', 'name',
        'description', 'address', 'postal_code', 'email', 'phone', 'fax', 'website', 'position', 'located',
    ];

    /**
     * The attributes that are spatial representations.
     *
     * @var array
     */
    protected $spatialFields = [
        'position'
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
            'facilities',
            'city.country',
            'provider'
        ]);
    }

    /**
     * Get the city that owns the hotel.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the provider associated with the hotel.
     */
    public function provider()
    {
        return $this->hasOne(HotelProvider::class);
    }

    /**
     * The providers that belong to the hotel.
     */
    public function providers()
    {
        return $this
            ->belongsToMany(Provider::class)
            ->using(HotelProvider::class)
            ->withPivot((new HotelProvider())->getFillable());
    }

    /**
     * The providers that belong to the hotel.
     */
    public function facilities()
    {
        return $this
            ->belongsToMany(Facility::class, (new HotelFacility())->getTable())
            ->using(HotelFacility::class)
            ->withPivot((new HotelFacility())->getFillable());
    }

    /**
     * Get the images for the hotel.
     */
    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    /**
     * The commissions that belong to the hotel.
     */
    public function commissions()
    {
        return $this
            ->belongsToMany(Commission::class, (new HotelCommission())->getTable())
            ->using(HotelCommission::class)
            ->withPivot((new HotelCommission())->getFillable());
    }
}
