<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoMessageReadStatus extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'promo_message_read_status';

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
        'promo_id', 'company_id', 'user_id', 'read_status',
    ];

    /**
     * Get the promo message that owns the promo message read status.
     */
    public function promoMessage()
    {
        return $this->belongsTo(PromoMessage::class, 'id', 'promo_id');
    }

    /**
     * Get the company that owns the promo message read status.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the user that owns the promo message read status.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
