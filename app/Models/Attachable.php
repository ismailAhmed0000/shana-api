<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachable extends Model
{
    protected $fillable = [
        'attachable_id',
        'attachable_type',
        'path',
        'type',
    ];
}
