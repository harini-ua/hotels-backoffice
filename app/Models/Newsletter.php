<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'newsletters';

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
        'type', 'company_id', 'registered_date_from', 'from', 'subject', 'message'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'registered_date_from',
    ];

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setRegisteredDateFromAttribute($value)
    {
        $this->attributes['registered_date_from'] =
            Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    /**
     * Get the company that owns the newsletter.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
