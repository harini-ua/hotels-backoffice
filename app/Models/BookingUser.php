<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingUser extends Model
{
    use SoftDeletes;

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
        'distributor_id', 'company_id', 'city', 'country_id', 'language_id',
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
     * Get the country that owns the user.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
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
