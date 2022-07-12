<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyExtraNight extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'company_extra_nights';

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
        'company_id', 'country_id', 'partner_price', 'customer_price', 'enable'
    ];

    /**
     * Get the company that owns the company extra night.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the currency that owns the company extra night.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
