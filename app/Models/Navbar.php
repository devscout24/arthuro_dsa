<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    protected $fillable = [
        'logo',
        'home',
        'for',
        'story',
        'waitlist',
    ];
}
