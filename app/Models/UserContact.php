<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
    ];
}
