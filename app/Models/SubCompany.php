<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCompany extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'sub_companies';

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
        'company_id', 'company_name', 'commission', 'status',
    ];

    /**
     * Get the company that owns the sub company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
