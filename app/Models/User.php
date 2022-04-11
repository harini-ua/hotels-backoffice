<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'title', 'firstname', 'lastname', 'email', 'password', 'company_name', 'phone', 'country_id',
        'city_id', 'address', 'status', 'master', 'newsletter', 'currency_id', 'language_id', 'last_login_at', 'ip_address',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * The companies that belong to the user.
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_user');
    }

    /**
     * The distributors that belong to the user.
     */
    public function distributors()
    {
        return $this->belongsToMany(Distributor::class, 'distributor_user');
    }

    /**
     * Get the bookings for the user.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the country that owns the user.
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
     * Get the currency that owns the user.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the language that owns the user.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if ((\Auth::user())->hasAnyRole(['distributor'])) {
            return $this->username;
        }

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
