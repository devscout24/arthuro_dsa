<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactDynamic extends Model
{
    protected $fillable = [
        'title',
        'description',
        'name_label',
        'name_placeholder',
        'email_label',
        'email_placeholder',
        'phone_label',
        'phone_placeholder',
        'message_label',
        'message_placeholder',
        'button',
    ];
}
