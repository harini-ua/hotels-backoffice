<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpFilter extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip_filter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address', 'comment', 'creator_id', 'expiry',
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
