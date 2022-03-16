<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountVoucher extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'discount_vouchers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'voucher_type', 'voucher_codes_count', 'amount', 'amount_type', 'currency_id', 'company_id',
        'description', 'commission', 'min_amount', 'expiry',
    ];

    /**
     * Get the currency that owns the discount.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the company that owns the discount.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the codes for the discount voucher.
     */
    public function codes()
    {
        return $this->hasMany(DiscountVoucherCode::class);
    }
}
