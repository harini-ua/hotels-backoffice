<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PartnerEnvironment extends Pivot
{
    public const TABLE_NAME = 'partner_environment';

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
        'status', 'check_redeem_url', 'redeem_url', 'url', 'username', 'password', 'api_key', 'api_token', 'host',
        'port', 'protocol', 'database', 'layout_check', 'layout_redeem', 'action', 'get_balance_script',
        'get_redeem_script', 'type', 'partner_inc', 'partner_code', 'user_id', 'c_user_id',
    ];
}
