<?php

namespace App\Models;

use App\Http\Controllers\CompanySaleOfficeLevel1CommissionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'holder_name', 'company_name', 'category', 'country_id', 'city_id', 'language_id', 'admin_id', 'user_id',
        'address', 'email', 'phone', 'comment', 'status', 'level', 'vat', 'newsletter', 'login_type', 'access_codes'
    ];

    /**
     * Get the supports for the company.
     */
    public function supports()
    {
        return $this->hasMany(CompanySupport::class);
    }

    /**
     * Get the homepage options associated with the company.
     */
    public function homepageOptions()
    {
        return $this->hasOne(CompanyHomepageOption::class);
    }

    /**
     * Get the booking commissions associated with the company.
     */
    public function bookingCommission()
    {
        return $this->hasOne(CompanyBookingCommission::class);
    }

    /**
     * Get the main options associated with the company.
     */
    public function mainOptions()
    {
        return $this->hasOne(CompanyMainOption::class);
    }

    /**
     * Get the prefilled option associated with the company.
     */
    public function prefilledOption()
    {
        return $this->hasOne(CompanyPrefilledOption::class);
    }

    /**
     * Get the extra night associated with the company.
     */
    public function extraNight()
    {
        return $this->hasOne(CompanyExtraNight::class);
    }

    /**
     * The users that belong to the company.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'company_user');
    }

    /**
     * Get the country that owns the company.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the company.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the language that owns the company.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the employee that owns the company.
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin that owns the company.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * The distributors that belong to the company.
     */
    public function distributors()
    {
        return $this->belongsToMany(Distributor::class, 'distributor_company');
    }

    /**
     * Get the discount for the company.
     */
    public function discounts()
    {
        return $this->hasMany(DiscountVoucher::class);
    }

    /**
     * Get the sale office commissions for the company.
     */
    public function saleOfficeCommissions()
    {
        return $this->hasMany(CompanySaleOfficeCommission::class);
    }

    /**
     * Get the access codes for the company.
     */
    public function accessCodes()
    {
        return $this->hasMany(AccessCode::class);
    }

    /**
     * Get the VATs for the company.
     */
    public function vats()
    {
        return $this->hasMany(CompanyVat::class);
    }
}
