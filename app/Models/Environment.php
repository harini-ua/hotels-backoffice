<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'environments';

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
        'name',
    ];

    /**
     * The providers that belong to the environment.
     */
    public function providers()
    {
        return $this
            ->belongsToMany(Provider::class)
            ->using(EnvironmentProvider::class);
    }
}
