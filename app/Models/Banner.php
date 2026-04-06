<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'comming_soon',
        'title',
        'description',
        'button',
        'tagline',
        'image',
        'career',
        'features',
        'icons',
    ];

    protected $casts = [
        'image' => 'array',
        'features' => 'array',
        'icons' => 'array',
    ];
}
