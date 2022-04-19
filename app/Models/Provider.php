<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'providers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'description', 'active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'environments',
    ];

    /**
     * The cities that belong to the provider.
     */
    public function cities()
    {
        return $this
            ->belongsToMany(City::class)
            ->using(CityProvider::class)
            ->withPivot((new CityProvider())->getFillable());
    }

    /**
     * The environments that belong to the provider.
     */
    public function environments()
    {
        return $this
            ->belongsToMany(Environment::class)
            ->using(EnvironmentProvider::class)
            ->withPivot((new EnvironmentProvider)->getFillable());
    }

    /**
     * The hotels that belong to the provider.
     */
    public function hotels()
    {
        return $this
            ->belongsToMany(Hotel::class)
            ->using(HotelProvider::class)
            ->withPivot((new HotelProvider())->getFillable());
    }
}
