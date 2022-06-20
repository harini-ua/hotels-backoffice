<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class BookingUser extends Model
{
    use HasRoles, SoftDeletes;

    public const TABLE = 'booking_users';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'email', 'password', 'status', 'company_name', 'address', 'phone',
        'distributor_id', 'company_id', 'sub_company_id', 'city', 'country_id', 'language_id', 'partner_gitfcard_id',
        'partner_gitfcard_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The companies that belong to the booking user.
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_user');
    }

    /**
     * The distributors that belong to the booking user.
     */
    public function distributors()
    {
        return $this->belongsToMany(Distributor::class, 'distributor_user');
    }

    /**
     * Get the distributor that owns the booking user.
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * Get the company that owns the booking user.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the country that owns the booking user.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the user.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the language that owns the booking user.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the booking user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Get the user's active.
     *
     * @return string
     */
    public function getActiveAttribute()
    {
        return (boolean) $this->status;
    }
}
