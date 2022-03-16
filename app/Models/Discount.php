<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
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
     * Get the codes for the discount voucher.
     */
    public function codes()
    {
        return $this->hasMany(DiscountCode::class);
    }

    /**
     * Get the currency associated with the discount voucher.
     */
    public function currency()
    {
        return $this->hasOne(Currency::class);
    }

    /**
     * Get the company associated with the discount voucher.
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }
}
