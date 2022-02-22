<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    use SpatialTrait;

    protected $table = 'hotels';

    protected $fillable = [
        'city_id',
        'status', 'active', 'rating', 'popularity', 'recommended',
        'special_offer', 'name', 'description', 'address', 'postal_code'
    ];

    protected $spatialFields = [
        'position'
    ];
}
