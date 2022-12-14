<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'languages';

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
        'name', 'code', 'active'
    ];

    /**
     * Get the countries for the language.
     */
    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    /**
     * The distributors that belong to the language.
     */
    public function distributors()
    {
        return $this->belongsToMany(Distributor::class, 'distributor_language');
    }

    /**
     * Get the users for the language.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
