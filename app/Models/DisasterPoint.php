<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterPoint extends Model
{
    protected $fillable = [
        'type',
        'description',
        'latitude',
        'longitude',
    ];

    public function attachable()
    {
        return $this->morphTo();
    }
}
