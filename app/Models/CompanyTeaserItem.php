<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTeaserItem extends Model
{
    use HasFactory;

    public const IMAGE_DIRECTORY = 'public/teaser/';
    public const IMAGE_EXTENSIONS = [ 'png', 'jpg', 'jpeg' ];
    public const IMAGE_KILOBYTES_SIZE = 4096;
    public const IMAGE_FIELDS = [ 'image' ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_teaser_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teaser_id', 'type', 'image', 'title', 'text',
    ];

    /**
     * Get the teaser that owns the teaser item.
     */
    public function teaser()
    {
        return $this->belongsTo(CompanyTeaser::class);
    }
}
