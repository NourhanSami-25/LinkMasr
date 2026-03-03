<?php

namespace App\Models\hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\user\User;


class Balance extends Model
{
    protected $fillable =
        [
            'user_id',
            'year',
            'total_days',
            'used_days'
        ];

    protected $casts = [
        'total_days' => 'integer',
        'used_days' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
