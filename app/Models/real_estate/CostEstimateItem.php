<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CostEstimateItem extends Model
{
    protected $table = 'cost_estimate_items';

    protected $fillable = [
        'estimate_id',
        'material_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function estimate(): BelongsTo
    {
        return $this->belongsTo(CostEstimate::class, 'estimate_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(ConstructionMaterial::class, 'material_id');
    }
}
