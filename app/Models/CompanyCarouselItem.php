<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCarouselItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_carousel_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'carousel_id', 'image', 'text',
    ];

    /**
     * Get the carousel that owns the carousel item.
     */
    public function carousel()
    {
        return $this->belongsTo(CompanyCarousel::class);
    }
}
