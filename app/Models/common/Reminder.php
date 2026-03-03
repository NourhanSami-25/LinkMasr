<?php

namespace App\Models\common;

use App\Models\user\User;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'user_id',
        'assigned_to',
        'is_repeated',
        'repeat_every',
        'repeat_counter',
        'description',
        'status',
        'referable_id',
        'referable_type'
    ];

    /**
     * Get the parent referable model (morph relation).
     */
    public function referable()
    {
        return $this->morphTo();
    }

    /**
     * The user that the reminder belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
