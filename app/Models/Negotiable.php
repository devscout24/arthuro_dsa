<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negotiable extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'tagline',
    ];

    protected $casts = [
        'tagline' => 'array',
    ];
}
