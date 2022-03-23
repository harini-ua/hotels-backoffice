<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Hotel extends Model
{
    use HasFactory, Searchable, SpatialTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id', 'status', 'blacklisted', 'rating', 'popularity', 'recommended', 'special_offer', 'name',
        'description', 'address', 'postal_code', 'position',
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
     *  Retrieve of the models searchable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function makeAllSearchableUsing($query)
    {
        return $query->with([
            'facilities',
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
