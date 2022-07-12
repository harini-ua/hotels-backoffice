<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountVoucherCode extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'discount_voucher_codes';

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
