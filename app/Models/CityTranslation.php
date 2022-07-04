<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'city_translations';

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
        'country_id', 'city_id', 'language_id', 'city_name', 'translation',
    ];

    /**
     * Get the country that owns the city translation.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the city translation.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the language that owns the city translation.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
