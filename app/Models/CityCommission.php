<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityCommission extends Model
{
    public const TABLE_NAME = 'city_commissions';

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
        'company_id', 'city_id', 'commission'
    ];

    /**
     * Get the company that owns the city commission.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the city that owns the city commission.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
