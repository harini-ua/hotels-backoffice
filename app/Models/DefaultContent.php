<?php

namespace App\Models;

use App\Traits\ImageUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultContent extends Model
{
    use ImageUpload, HasFactory;

    public const IMAGE_DIRECTORY = 'public/default/';
    public const IMAGE_EXTENSIONS = [ 'png', 'jpg', 'jpeg' ];
    public const IMAGE_KILOBYTES_SIZE = 4096;

    public const FIELDS = [];
    public const IMAGE_FIELDS = [ 'logo' ];

    public const TABLE_NAME = 'default_content';

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
        'logo', 'carousel_id', 'teaser_id'
    ];

    /**
     * Get the carousel that owns the default content.
     */
    public function carousel()
    {
        return $this->belongsTo(CompanyCarousel::class);
    }

    /**
     * Get the teaser that owns the default content.
     */
    public function teaser()
    {
        return $this->belongsTo(CompanyTeaser::class);
    }
}
