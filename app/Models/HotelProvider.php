<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Laravel\Scout\Searchable;

class HotelProvider extends Pivot
{
    use Searchable;

    public const TABLE_NAME = 'hotel_provider';

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
        'hotel_id', 'provider_id', 'provider_hotel_code', 'tti_code', 'giata_code', 'status', 'blacklisted', 'hotel_name',
    ];

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return Hotel::TABLE_NAME;
    }

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return !$this->blacklisted;
    }

    /**
     *  Retrieve of the models searchable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function makeAllSearchableUsing($query)
    {
        return $query->with([
            'hotel.facilities',
            'provider'
        ]);
    }

    /**
     * Get the hotel that owns the hotel provider.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the provider that owns the hotel provider.
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
