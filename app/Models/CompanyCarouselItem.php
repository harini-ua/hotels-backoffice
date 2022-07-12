<?php

namespace App\Models;

use App\Traits\ImageUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCarouselItem extends Model
{
    use ImageUpload, HasFactory;

    public const IMAGE_DIRECTORY = 'carousel';
    public const IMAGE_EXTENSIONS = [ 'png', 'jpg', 'jpeg' ];
    public const IMAGE_KILOBYTES_SIZE = 4096;
    public const IMAGE_FIELDS = [ 'image' ];

    public const TABLE_NAME = 'company_carousel_items';

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
        'carousel_id', 'type', 'image', 'text',
    ];

    /**
     * Get the carousel that owns the carousel item.
     */
    public function carousel()
    {
        return $this->belongsTo(CompanyCarousel::class);
    }
}
