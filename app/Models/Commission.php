<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The countries that belong to the commission.
     */
    public function countries()
    {
        return $this
            ->belongsToMany(Country::class, (new CountryCommission())->getTable())
            ->using(CountryCommission::class)
            ->withPivot((new CountryCommission())->getFillable());
    }

    /**
     * The cities that belong to the commission.
     */
    public function cities()
    {
        return $this
            ->belongsToMany(City::class, (new CityCommission())->getTable())
            ->using(CityCommission::class)
            ->withPivot((new CityCommission())->getFillable());
    }

    /**
     * The hotels that belong to the commission.
     */
    public function hotels()
    {
        return $this
            ->belongsToMany(Hotel::class, (new HotelCommission())->getTable())
            ->using(HotelCommission::class)
            ->withPivot((new HotelCommission())->getFillable());
    }
}
