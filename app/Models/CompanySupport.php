<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySupport extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'company_support';

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
        'company_id', 'country_id', 'email', 'phone', 'work_hours',
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
