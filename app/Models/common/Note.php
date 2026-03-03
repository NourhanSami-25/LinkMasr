<?php

namespace App\Models\common;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'content', 'username', 'referable_id', 'referable_type', 'created_by'
    ];

    /**
     * Get the parent referable model (morph relation).
     */
    public function referable()
    {
        return $this->morphTo();
    }
}
