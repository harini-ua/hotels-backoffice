<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes, HasFactory;

    public const TABLE_NAME = 'companies';

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
        'holder_name', 'company_name', 'category', 'country_id', 'city_id', 'language_id', 'admin_id', 'user_id',
        'address', 'email', 'phone', 'comment', 'status', 'level', 'sub_companies', 'vat', 'newsletter', 'login_type',
        'access_codes'
    ];

    /**
     * Get the car's owner.
     */
    public function partner()
    {
        return $this->hasOneThrough(
            Partner::class,
            CompanyPartner::class,
            'company_id',
            'id',
            'id',
            'partner_id',
        );
    }

    /**
     * Get the car's owner.
     */
    public function partnerProduct()
    {
        return $this->hasOneThrough(
            PartnerProduct::class,
            CompanyPartner::class,
            'company_id',
            'partner_id',
            'id',
            'id',
        );
    }

    /**
     * Get the supports for the company.
     */
    public function supports()
    {
        return $this->hasMany(CompanySupport::class);
    }

    /**
     * Get the sub companies for the company.
     */
    public function subCompanies()
    {
        return $this->hasMany(SubCompany::class);
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
     * The users that belong to the company.
     */
    public function bookingUsers()
    {
        return $this->belongsToMany(BookingUser::class, 'company_booking_user')
            ->withTimestamps();
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
     * The companies that belong to the distributor.
     */
    public function promoMessages()
    {
        return $this->belongsToMany(
            PromoMessage::class,
            'promo_company',
            'company_id',
            'promo_id',
        );
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
        return $this->hasMany(CompanySaleOfficeCommission::class, 'company_id');
    }

    /**
     * Get the sale office commissions for the company by conditions.
     */
    public function saleOfficeCommissionsByConditions($level, $country_id = null)
    {
        $relation = $this->saleOfficeCommissions();
        $relation->where('level', $level);

        if ($country_id) {
            $relation->where('country_id', $country_id);
        }

        return $relation;
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

    /**
     * Get the country VAT for the company.
     */
    public function vat($country_id)
    {
        return $this->hasOne(CompanyVat::class)
            ->where('country_id', $country_id);
    }

    /**
     * Get the city commissions for the company.
     */
    public function cityCommissions()
    {
        return $this->hasMany(CityCommission::class);
    }

    /**
     * Get the country commissions for the company.
     */
    public function countryCommissions()
    {
        return $this->hasMany(CountryCommission::class);
    }
}
