<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyVat extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'company_vat';

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
        'company_id', 'citizen_id', 'country_id', 'percentage',
    ];

    /**
     * Get the company that owns the VAT.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the citizen that owns the VAT.
     */
    public function citizen()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the country that owns the VAT.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
