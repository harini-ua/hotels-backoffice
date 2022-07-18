<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    public function checks()
    {
        return $this->hasMany(Check::class);
    }
}
