<?php

namespace App\Models\common;

use Illuminate\Database\Eloquent\Model;
use App\Models\user\User;

class Discussion extends Model
{
    public function discussionable()
    {
        return $this->morphTo();
    }

    public function messages()
    {
        return $this->hasMany(DiscussionMessage::class)->latest();
    }
}
