<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountVoucherCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'discount_voucher_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discount_voucher_id', 'code', 'status',
    ];

    /**
     * Get the discount that owns the code.
     */
    public function discount()
    {
        return $this->belongsTo(DiscountVoucher::class);
    }
}
