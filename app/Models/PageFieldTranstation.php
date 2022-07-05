<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageFieldTranstation extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'page_field_translations';

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
        'field_id', 'page_id', 'country_id', 'name', 'translation', 'status', 'is_duplicate'
    ];
}
