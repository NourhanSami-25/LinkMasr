<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'tax_number',
        'commercial_register',
        'phone',
        'email',
        'address',
        'bank_name',
        'bank_account',
        'iban',
        'contact_person',
        'contact_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope for suppliers.
     */
    public function scopeSuppliers($query)
    {
        return $query->where('type', 'supplier');
    }

    /**
     * Scope for subcontractors.
     */
    public function scopeSubcontractors($query)
    {
        return $query->where('type', 'subcontractor');
    }

    /**
     * Scope for active vendors.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the tenders awarded to this vendor.
     */
    public function awardedTenders()
    {
        return $this->hasMany(Tender::class, 'awarded_to');
    }

    /**
     * Get the bids submitted by this vendor.
     */
    public function bids()
    {
        return $this->hasMany(TenderBid::class);
    }

    /**
     * Get the subcontracts for this vendor.
     */
    public function subcontracts()
    {
        return $this->hasMany(Subcontract::class);
    }

    /**
     * Get the purchase orders for this vendor.
     */
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
