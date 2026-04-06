<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Already extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'tag_head',
        'tag_body',
        'tag_number',
    ];

    protected $casts = [
        'tag_head' => 'array',
        'tag_body' => 'array',
        'tag_number' => 'array',
    ];
}
