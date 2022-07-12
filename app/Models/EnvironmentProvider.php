<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EnvironmentProvider extends Pivot
{
    public const TABLE_NAME = 'environment_provider';

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
        'status', 'username', 'password', 'client_agent_id', 'timeout', 'affiliation', 'user_code', 'api_key',
        'api_secret', 'main_endpoint', 'search_endpoint', 'recheck_endpoint', 'pre_reservation_endpoint',
        'booking_endpoint', 'location_countries_endpoint', 'rate_comments_endpoint'
    ];
}
