<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'boq_id',
        'previous_qty',
        'current_qty',
        'cumulative_qty',
        'unit_price',
        'amount',
    ];

    protected $casts = [
        'previous_qty' => 'decimal:4',
        'current_qty' => 'decimal:4',
        'cumulative_qty' => 'decimal:4',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the invoice.
     */
    public function invoice()
    {
        return $this->belongsTo(ClientInvoice::class, 'invoice_id');
    }

    /**
     * Get the BOQ item.
     */
    public function boq()
    {
        return $this->belongsTo(ConstructionBoq::class, 'boq_id');
    }

    /**
     * Auto-calculate on save.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->cumulative_qty = $model->previous_qty + $model->current_qty;
            $model->amount = $model->current_qty * $model->unit_price;
        });
    }
}
