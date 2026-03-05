<?php

namespace App\Models\utility;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'subject',
        'message',
        'status',
        'expire_after',
        'show_staff',
        'show_clients',
        'show_name',
        'created_by',
        'user_id'
    ];
}
