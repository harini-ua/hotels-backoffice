<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyFieldTranslation extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'company_field_translations';

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
        'field_id', 'company_id', 'language_id', 'country_id', 'name', 'translation', 'status', 'is_duplicate'
    ];

    /**
     * Get the field that owns the translation.
     */
    public function field()
    {
        return $this->belongsTo(CompanyField::class);
    }
}
