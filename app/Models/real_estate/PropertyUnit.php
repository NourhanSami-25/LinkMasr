<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\client\Client;
use App\Models\project\Project;

class PropertyUnit extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'status',
        'price',
        'area',
        'drawing_id',
        'description',
        'pos_x',
        'pos_y',
        'sold_date',
        'buyer_id'
    ];

    protected $casts = [
        'area' => 'decimal:2',
        'price' => 'decimal:2',
        'pos_x' => 'decimal:2',
        'pos_y' => 'decimal:2',
        'sold_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'buyer_id');
    }

    // Scope for available units
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Scope for sold units
    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    // Scope for reserved units
    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }
}