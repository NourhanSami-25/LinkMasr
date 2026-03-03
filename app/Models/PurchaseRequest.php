<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'reference_no',
        'date',
        'required_date',
        'notes',
        'status',
        'requested_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'date' => 'date',
        'required_date' => 'date',
        'approved_at' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class, 'request_id');
    }

    public function requester()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'approved_by');
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'request_id');
    }

    public function getTotalEstimatedAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * ($item->estimated_price ?? 0);
        });
    }

    public static function generateReferenceNo($projectId)
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        return sprintf('PR-%s-%04d-%03d', $year, $projectId, $count);
    }
}
