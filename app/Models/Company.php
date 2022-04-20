<?php

namespace App\Models;

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
        'holder_name', 'company_name', 'category', 'country_id', 'city_id', 'language_id', 'address', 'email', 'phone',
        'status', 'level', 'vat', 'newsletter',
    ];

    /**
     * Get the homepage options associated with the company.
     */
    public function homepageOptions()
    {
        return $this->hasOne(CompanyHomepageOption::class);
    }

    /**
     * Get the main options associated with the company.
     */
    public function mainOptions()
    {
        return $this->hasOne(CompanyMainOption::class);
    }

    /**
     * Get the prefilled options associated with the company.
     */
    public function prefilledOptions()
    {
        return $this->hasOne(CompanyPrefilledOption::class);
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
     * The distributors that belong to the company.
     */
    public function distributors()
    {
        return $this->belongsToMany(Distributor::class, 'distributor_company');
    }

    /**
     * Get the discount for the blog company.
     */
    public function discounts()
    {
        return $this->hasMany(DiscountVoucher::class);
    }
}
