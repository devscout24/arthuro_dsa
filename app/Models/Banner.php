<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'description',
        'features',
        'icons',
    ];

    protected $casts = [
        'features' => 'array',
        'icons' => 'array',
    ];
}
