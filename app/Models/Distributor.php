<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'distributors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'address', 'phone',
    ];

    /**
     * The users that belong to the distributor.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'distributor_user');
    }

    /**
     * The companies that belong to the distributor.
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'distributor_company');
    }

    /**
     * The countries that belong to the distributor.
     */
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'distributor_country');
    }

    /**
     * The languages that belong to the distributor.
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'distributor_language');
    }
}
