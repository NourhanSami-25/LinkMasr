<?php

namespace App\Models\reminder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_to',
        'referable_id',
        'referable_type',
        'subject',
        'description',
        'date',
        'remind_before',
        'remind_at_event',
        'before_reminded',
        'event_reminded',
        'priority',
        'status',
        'is_repeated',
        'repeat_every',
        'repeat_every_type',
        'created_by',
    ];

    public function referable()
    {
        return $this->morphTo();
    }
}
