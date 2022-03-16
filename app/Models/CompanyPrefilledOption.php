<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPrefilledOption extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_prefilled_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'adults_count', 'nights_count', 'rooms_count', 'country_id', 'city_id', 'checkout_editable',
    ];

    /**
     * Get the company that owns the company prefilled option.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
