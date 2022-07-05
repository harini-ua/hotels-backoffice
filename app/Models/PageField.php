<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageField extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'page_fields';

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
        'page_id', 'name', 'type', 'max_length', 'is_mobile'
    ];

    /**
     * Get the page that owns the field.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
