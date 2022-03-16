<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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
        'title', 'firstname', 'lastname', 'email', 'password', 'company_name', 'phone', 'country_id', 'city_id',
        'address', 'status', 'last_login', 'newsletter', 'currency_id', 'language_id', 'ip_address',
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
        'last_login' => 'datetime',
    ];

    /**
     * Get the country associated with the user.
     */
    public function country()
    {
        return $this->hasOne(Country::class);
    }

    /**
     * Get the city associated with the user.
     */
    public function city()
    {
        return $this->hasOne(City::class);
    }

    /**
     * Get the currency associated with the user.
     */
    public function currency()
    {
        return $this->hasOne(Currency::class);
    }

    /**
     * Get the language associated with the user.
     */
    public function language()
    {
        return $this->hasOne(Language::class);
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
