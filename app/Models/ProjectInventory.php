<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInventory extends Model
{
    use HasFactory;

    protected $table = 'project_inventory';

    protected $fillable = [
        'project_id',
        'item_code',
        'description',
        'unit',
        'quantity',
        'average_cost',
        'min_level',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'average_cost' => 'decimal:2',
        'min_level' => 'decimal:4',
    ];

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'inventory_id');
    }

    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->average_cost;
    }

    public function getIsLowStockAttribute()
    {
        return $this->quantity <= $this->min_level;
    }
}
