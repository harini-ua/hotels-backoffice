<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySaleOfficeCommission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_sale_office_commission';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'level', 'sale_office_country_id', 'commission',
    ];

    /**
     * Get the company that owns the company booking commission.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
