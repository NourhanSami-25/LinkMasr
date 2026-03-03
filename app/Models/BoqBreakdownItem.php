<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqBreakdownItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'boq_id',
        'category_id',
        'item_code',
        'description',
        'unit',
        'quantity',
        'unit_price',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the BOQ item this breakdown belongs to.
     */
    public function boq()
    {
        return $this->belongsTo(ConstructionBoq::class, 'boq_id');
    }

    /**
     * Get the category of this breakdown item.
     */
    public function category()
    {
        return $this->belongsTo(BoqBreakdownCategory::class, 'category_id');
    }

    /**
     * Boot method to auto-calculate total_price.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_price = $model->quantity * $model->unit_price;
        });
    }
}
