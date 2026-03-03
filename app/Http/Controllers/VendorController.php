<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of vendors.
     */
    public function index(Request $request)
    {
        $this->authorize('accessprocurement', ['view']);
        
        $query = Vendor::query();
        
        if ($request->type) {
            $query->where('type', $request->type);
        }
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        
        $vendors = $query->orderBy('name')->paginate(20);
        
        return view('procurement.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new vendor.
     */
    public function create()
    {
        $this->authorize('accessprocurement', ['create']);
        
        return view('procurement.vendors.create');
    }

    /**
     * Store a newly created vendor.
     */
    public function store(Request $request)
    {
        $this->authorize('accessprocurement', ['create']);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:supplier,subcontractor',
            'tax_number' => 'nullable|string|max:50',
            'commercial_register' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        Vendor::create($validated);

        return redirect()->route('vendors.index')->with('success', 'تم إضافة المورد بنجاح');
    }

    /**
     * Display the specified vendor.
     */
    public function show($id)
    {
        $this->authorize('accessprocurement', ['view']);
        
        $vendor = Vendor::with(['subcontracts.project', 'bids.tender'])->findOrFail($id);
        
        return view('procurement.vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified vendor.
     */
    public function edit($id)
    {
        $this->authorize('accessprocurement', ['modify']);
        
        $vendor = Vendor::findOrFail($id);
        
        return view('procurement.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified vendor.
     */
    public function update(Request $request, $id)
    {
        $this->authorize('accessprocurement', ['modify']);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:supplier,subcontractor',
            'tax_number' => 'nullable|string|max:50',
            'commercial_register' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($validated);

        return redirect()->route('vendors.index')->with('success', 'تم تحديث بيانات المورد بنجاح');
    }

    /**
     * Remove the specified vendor.
     */
    public function destroy($id)
    {
        $this->authorize('accessprocurement', ['delete']);
        
        $vendor = Vendor::findOrFail($id);
        
        // Check if vendor has related records
        if ($vendor->subcontracts()->exists() || $vendor->bids()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف المورد لوجود سجلات مرتبطة به');
        }
        
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'تم حذف المورد بنجاح');
    }

    /**
     * Toggle vendor active status.
     */
    public function toggleStatus($id)
    {
        $this->authorize('accessprocurement', ['modify']);
        
        $vendor = Vendor::findOrFail($id);
        $vendor->is_active = !$vendor->is_active;
        $vendor->save();

        return redirect()->back()->with('success', 'تم تحديث حالة المورد بنجاح');
    }
}
