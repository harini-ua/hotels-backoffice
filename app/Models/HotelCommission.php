<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HotelCommission extends Pivot
{
    public const TABLE_NAME = 'hotel_commissions';

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
        'company_id', 'hotel_id', 'commission'
    ];

    /**
     * Get the company that owns the city commission.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the hotel that owns the city commission.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
