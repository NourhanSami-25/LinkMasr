<?php

namespace App\Models\hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\user\User;


class Department extends Model
{
    public $timestamps = false;
    
    protected $fillable =
    [
        'sector_id',
        'manager_id',
        'name',
        'subject',
        'email',
        'status'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
