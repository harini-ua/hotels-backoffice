<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'name', 'status', 'master',
    ];

    /**
     * Get the user that owns the distributor.
     */
    public function master()
    {
        return $this->users()
            ->wherePivot('master', true);
    }

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
