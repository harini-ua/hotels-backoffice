<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
    ];

    /**
     * Get the countries for the currency.
     */
    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    /**
     * Get the user that owns the currency.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
