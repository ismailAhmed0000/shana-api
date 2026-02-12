<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafePoint extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'latitude',
        'capacity',
        'longitude',
        'status',
    ];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
