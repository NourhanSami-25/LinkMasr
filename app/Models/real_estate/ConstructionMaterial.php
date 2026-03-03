<?php

namespace App\Models\real_estate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConstructionMaterial extends Model
{
    protected $table = 'construction_materials';

    protected $fillable = [
        'name',
        'unit',
        'description',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(MaterialPrice::class, 'material_id');
    }

    public function getLatestPriceAttribute()
    {
        return $this->prices()
            ->whereDate('date', '<=', now())
            ->orderBy('date', 'desc')
            ->first()
            ->price ?? 0;
    }
}
