<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTeaser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_teasers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'default'
    ];

    /**
     * Get the items for the teaser.
     */
    public function items()
    {
        return $this->hasMany(CompanyTeaserItem::class, 'teaser_id');
    }
}
