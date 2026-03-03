<?php

namespace App\Models\common;

use Illuminate\Database\Eloquent\Model;
use App\Models\user\User;

class DiscussionMessage extends Model
{
    protected $fillable = ['message', 'user_id', 'discussion_id'];

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
