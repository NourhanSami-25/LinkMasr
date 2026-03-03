<?php

namespace App\Models\common;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'date',
        'username',
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
}
