<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHomepageOption extends Model
{
    use HasFactory;

    public const IMAGE_DIRECTORY = 'public/companies/';
    public const IMAGE_EXTENSIONS = [ 'png', 'jpg', 'jpeg' ];
    public const IMAGE_KILOBYTES_SIZE = 4096;

    public const IMAGE_FIELDS = [ 'logo' ];

    public const TABLE_NAME = 'company_homepage_options';

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
        'company_id', 'theme_id', 'logo', 'carousel_id', 'teaser_id',
    ];

    /**
     * Get the company that owns the company homepage option.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the theme that owns the company homepage option.
     */
    public function theme()
    {
        return $this->belongsTo(CompanyTheme::class);
    }

    /**
     * Get the carousel that owns the company homepage option.
     */
    public function carousel()
    {
        return $this->belongsTo(CompanyCarousel::class);
    }

    /**
     * Get the teaser that owns the company homepage option.
     */
    public function teaser()
    {
        return $this->belongsTo(CompanyTeaser::class);
    }
}
