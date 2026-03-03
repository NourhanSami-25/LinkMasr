<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'boq_id',
        'breakdown_item_id',
        'description',
        'unit',
        'quantity',
        'estimated_price',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'estimated_price' => 'decimal:2',
    ];

    public function request()
    {
        return $this->belongsTo(PurchaseRequest::class, 'request_id');
    }

    public function boq()
    {
        return $this->belongsTo(ConstructionBoq::class, 'boq_id');
    }

    public function breakdownItem()
    {
        return $this->belongsTo(BoqBreakdownItem::class, 'breakdown_item_id');
    }
}
