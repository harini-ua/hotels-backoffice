<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyExtraNight extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_extra_nights';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'country_id', 'partner_price', 'customer_price', 'enable'
    ];

    /**
     * Get the company that owns the company support.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the country that owns the company support.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
