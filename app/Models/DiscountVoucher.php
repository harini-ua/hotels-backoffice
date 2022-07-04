<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountVoucher extends Model
{
    use HasFactory, SoftDeletes;

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
        'description', 'commission_type', 'min_price', 'expiry',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expiry',
    ];

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setExpiryAttribute($value)
    {
        $this->attributes['expiry'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

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
