<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'reference_no',
        'title',
        'scope',
        'issue_date',
        'closing_date',
        'status',
        'awarded_to',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'closing_date' => 'date',
    ];

    /**
     * Get the project this tender belongs to.
     */
    public function project()
    {
        return $this->belongsTo(\App\Models\project\Project::class);
    }

    /**
     * Get the vendor awarded this tender.
     */
    public function awardedVendor()
    {
        return $this->belongsTo(Vendor::class, 'awarded_to');
    }

    /**
     * Get the user who created this tender.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\user\User::class, 'created_by');
    }

    /**
     * Get the tender items.
     */
    public function items()
    {
        return $this->hasMany(TenderItem::class);
    }

    /**
     * Get the bids for this tender.
     */
    public function bids()
    {
        return $this->hasMany(TenderBid::class);
    }

    /**
     * Get the subcontract created from this tender.
     */
    public function subcontract()
    {
        return $this->hasOne(Subcontract::class);
    }

    /**
     * Check if tender is open for bids.
     */
    public function getIsOpenAttribute()
    {
        return $this->status === 'open' && now()->lte($this->closing_date);
    }

    /**
     * Get the lowest bid amount.
     */
    public function getLowestBidAttribute()
    {
        return $this->bids()->min('bid_amount');
    }

    /**
     * Generate reference number.
     */
    public static function generateReferenceNo($projectId)
    {
        $count = self::where('project_id', $projectId)->count() + 1;
        return sprintf('TND-%04d-%03d', $projectId, $count);
    }
}
