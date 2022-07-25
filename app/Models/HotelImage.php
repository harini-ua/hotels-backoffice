<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelImage extends Model
{
    use HasFactory;

    public const IMAGE_DIRECTORY = 'public/hotels/';
    public const IMAGE_EXTENSIONS = [ 'png', 'jpg', 'jpeg' ];
    public const IMAGE_KILOBYTES_SIZE = 4096;

    public const IMAGE_FIELDS = [ 'image' ];

    public const TABLE_NAME = 'hotel_images';

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
        'hotel_id', 'image', 'primary'
    ];

    /**
     * Get the hotel that owns the image.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
