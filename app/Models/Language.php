<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'languages';

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
}
