<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcontract extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'vendor_id',
        'tender_id',
        'contract_no',
        'title',
        'scope',
        'contract_value',
        'start_date',
        'end_date',
        'retention_percentage',
        'advance_percentage',
        'advance_paid',
        'insurance_percentage',
        'status',
        'created_by',
        'terms',
    ];

    protected $casts = [
        'contract_value' => 'decimal:2',
        'retention_percentage' => 'decimal:2',
        'advance_percentage' => 'decimal:2',
        'advance_paid' => 'decimal:2',
        'insurance_percentage' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the project this subcontract belongs to.
     */
    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    /**
     * Get the vendor/subcontractor.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the tender this subcontract came from.
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    /**
     * Get the user who created this subcontract.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'created_by');
    }

    /**
     * Get the subcontract items.
     */
    public function items()
    {
        return $this->hasMany(SubcontractItem::class);
    }

    /**
     * Get the invoices for this subcontract.
     */
    public function invoices()
    {
        return $this->hasMany(SubcontractorInvoice::class);
    }

    /**
     * Get executed value.
     */
    public function getExecutedValueAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->executed_qty * $item->unit_price;
        });
    }

    /**
     * Get execution percentage.
     */
    public function getExecutionPercentageAttribute()
    {
        if ($this->contract_value == 0) return 0;
        return round(($this->executed_value / $this->contract_value) * 100, 2);
    }

    /**
     * Get remaining value.
     */
    public function getRemainingValueAttribute()
    {
        return $this->contract_value - $this->executed_value;
    }

    /**
     * Get total paid amount.
     */
    public function getTotalPaidAttribute()
    {
        return $this->invoices()->where('status', 'paid')->sum('net_amount');
    }

    /**
     * Get total retention held.
     */
    public function getTotalRetentionAttribute()
    {
        return $this->invoices()->sum('retention_amount');
    }

    /**
     * Generate contract number.
     */
    public static function generateContractNo($projectId)
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        return sprintf('SC-%s-%04d-%03d', $year, $projectId, $count);
    }
}
