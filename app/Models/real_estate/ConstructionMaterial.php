<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Model;

class ConstructionMaterial extends Model
{
    protected $fillable = [
        'name',
        'code',
        'category',
        'unit',
        'unit_price',
        'stock_quantity',
        'minimum_stock',
        'supplier',
        'description',
        'status'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'stock_quantity' => 'decimal:2',
        'minimum_stock' => 'decimal:2',
    ];

    // Scope for active materials
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Check if stock is low
    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->minimum_stock;
    }

    // Calculate total stock value
    public function getStockValueAttribute(): float
    {
        return $this->stock_quantity * $this->unit_price;
    }
}