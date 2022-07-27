<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Distributor extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'distributors';

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
        'name', 'email', 'address', 'phone', 'status',
    ];

    /**
     * The users that belong to the distributor.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'distributor_user');
    }

    /**
     * The companies that belong to the distributor.
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'distributor_company');
    }

    /**
     * The countries that belong to the distributor.
     */
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'distributor_country');
    }

    /**
     * The languages that belong to the distributor.
     */
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'distributor_language');
    }
}
