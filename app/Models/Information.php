<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';

    protected $fillable = [
        'title',
        'description',
        'email_label',
        'email',
        'email_icon',
        'tagline',
        'linkedin',
        'linkedin_icon',
        'instagram',
        'instagram_icon',
    ];
}
