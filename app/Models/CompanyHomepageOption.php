<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHomepageOption extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_homepage_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'theme_id', 'logo', 'carousel_id', 'testimonial_id',
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
     * Get the testimonial that owns the company homepage option.
     */
    public function testimonial()
    {
        return $this->belongsTo(CompanyTestimonial::class);
    }
}
