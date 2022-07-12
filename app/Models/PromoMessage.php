<?php

namespace App\Models;

use App\Traits\ImageUpload;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoMessage extends Model
{
    use ImageUpload, HasFactory;

    public const IMAGE_DIRECTORY = 'public/promo/';
    public const IMAGE_EXTENSIONS = [ 'png', 'jpg', 'jpeg' ];
    public const IMAGE_KILOBYTES_SIZE = 4096;

    public const IMAGE_FIELDS = [ 'image' ];

    public const TABLE_NAME = 'promo_messages';

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
        'headline', 'content', 'image', 'status', 'translateable', 'show_all_company',
        'language_id', 'creator_id', 'expiry_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expiry_date' => 'date',
    ];

    /**
     * The companies that belong to the distributor.
     */
    public function companies()
    {
        return $this->belongsToMany(
            Company::class,
            'promo_company',
            'promo_id',
            'company_id'
        );
    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Set the expiry date.
     *
     * @param  string  $value
     * @return void
     */
    public function setExpiryDateAttribute($value)
    {
        $this->attributes['expiry_date'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    /**
     * Get the language that owns the promo message.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the creator that owns the promo message.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
