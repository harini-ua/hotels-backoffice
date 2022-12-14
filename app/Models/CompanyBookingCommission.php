<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   CompanyBookingCommission extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'company_booking_commission';

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
        'company_id', 'standard_commission', 'booking_commission', 'payback_to_client',
        'minimal_commission', 'use_minimal_commission'
    ];

    /**
     * Get the company that owns the company booking commission.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
