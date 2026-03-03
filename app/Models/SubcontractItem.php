<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcontractItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcontract_id',
        'boq_id',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'executed_qty',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'executed_qty' => 'decimal:4',
    ];

    /**
     * Get the subcontract this item belongs to.
     */
    public function subcontract()
    {
        return $this->belongsTo(Subcontract::class);
    }

    /**
     * Get the BOQ item.
     */
    public function boq()
    {
        return $this->belongsTo(ConstructionBoq::class, 'boq_id');
    }

    /**
     * Get invoice items related to this subcontract item.
     */
    public function invoiceItems()
    {
        return $this->hasMany(SubcontractorInvoiceItem::class);
    }

    /**
     * Get remaining quantity.
     */
    public function getRemainingQtyAttribute()
    {
        return $this->quantity - $this->executed_qty;
    }

    /**
     * Get execution percentage.
     */
    public function getExecutionPercentageAttribute()
    {
        if ($this->quantity == 0) return 0;
        return round(($this->executed_qty / $this->quantity) * 100, 2);
    }

    /**
     * Auto-calculate total on save.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_price = $model->quantity * $model->unit_price;
        });
    }
}
