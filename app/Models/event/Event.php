<?php

namespace App\Models\event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'referable_id',
        'referable_type',
        'subject',
        'description',
        'location',
        'date',
        'due_date',
        'time',
        'due_time',
        'is_allday',
        'status',
        'created_by',
    ];

    public function referable()
    {
        return $this->morphTo();
    }
}
