<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PartnerEnvironment extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partner_environment';

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
