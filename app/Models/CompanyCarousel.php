<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCarousel extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'company_carousels';

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
        'default'
    ];

    /**
     * Get the items for the carousel.
     */
    public function items()
    {
        return $this->hasMany(CompanyCarouselItem::class, 'carousel_id');
    }
}
