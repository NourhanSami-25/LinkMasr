<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialPrice extends Model
{
    protected $table = 'material_prices';

    protected $fillable = [
        'material_id',
        'price',
        'date',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(ConstructionMaterial::class, 'material_id');
    }
}
