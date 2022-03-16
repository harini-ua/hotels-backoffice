<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'type',
    ];

    /**
     * Get the products for the partner.
     */
    public function products()
    {
        return $this->hasMany(PartnerProduct::class);
    }

    /**
     * The environments that belong to the partner.
     */
    public function environments()
    {
        return $this
            ->belongsToMany(Environment::class, (new PartnerEnvironment())->getTable())
            ->using(PartnerEnvironment::class)
            ->withPivot((new PartnerEnvironment())->getFillable());
    }
}
