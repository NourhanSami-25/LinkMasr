<?php

namespace App\Models\common;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'category',
        'type',
        'description',
        'path',
        'created_by',
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
