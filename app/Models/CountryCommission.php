<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryCommission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country_commissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'country_id', 'commission'
    ];

    /**
     * Get the company that owns the city commission.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the country that owns the city commission.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
