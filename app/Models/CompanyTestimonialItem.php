<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTestimonialItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_testimonial_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'testimonial_id', 'image', 'title', 'text',
    ];

    /**
     * Get the testimonial that owns the testimonial item.
     */
    public function testimonial()
    {
        return $this->belongsTo(CompanyTestimonial::class);
    }
}
