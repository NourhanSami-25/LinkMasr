<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'type',
        'reference_id',
        'reference_type',
        'quantity',
        'unit_cost',
        'date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'decimal:4',
        'unit_cost' => 'decimal:2',
    ];

    public function inventory()
    {
        return $this->belongsTo(ProjectInventory::class, 'inventory_id');
    }

    public function reference()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'created_by');
    }

    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->unit_cost;
    }
}
