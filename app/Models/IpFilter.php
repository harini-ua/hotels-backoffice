<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpFilter extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'ip_filter';

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
        'type', 'ip_address', 'comment', 'creator_id', 'expiry',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expiry' => 'date',
    ];

    /**
     * Get the creator that owns the ip filter.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
