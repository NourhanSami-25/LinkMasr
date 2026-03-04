<?php

namespace App\Services\finance;
use Illuminate\Support\Facades\Auth;
use App\Models\finance\Invoice;
use App\Models\client\Client;

class InvoiceService
{
    public function getAll()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('finance', 'full') || $authUser->hasAccess('finance', 'view_global')) {
            return Invoice::all();
        }
        else
        {
             return Invoice::where('created_by' , $authUser->id)->get();
        }
        
    }

    public function create(array $data, array $financeItems = [])
    {
        $invoice = new Invoice();

        // Calculate invoice totals
        $subtotal = 0;
        $totalTax = 0;
        $validItems = array_filter($financeItems, function ($item) {
            return !is_null($item['name']) && !is_null($item['amount']);
        });
        foreach ($validItems as $item) {
            $qty = isset($item['qty']) ? (float)$item['qty'] : 1;
            $amount = isset($item['amount']) ? (float)$item['amount'] : 0;
            $tax = isset($item['tax']) ? ((float)$item['tax'] / 100) *  $amount  : 0;
            $subtotal += $qty * ($amount + $tax);
            $totalTax += $tax * $qty;
        }
        $data['subtotal'] = $subtotal;
        $data['items_tax_value'] = $totalTax;

        // Set default values for missing fields
        $data['discount_type'] = $data['discount_type'] ?? 'none';
        $data['discount_amount_type'] = $data['discount_amount_type'] ?? 'percentage';
        $data['discount'] = $data['discount'] ?? 0;
        $data['fixed_discount'] = $data['fixed_discount'] ?? 0;
        $data['tax'] = $data['tax'] ?? 0;
        $data['overall_tax_value'] = 0;
        $data['total_discount'] = 0;
        $data['percentage_discount_value'] = 0;

        if ($data['discount_type'] == 'before_tax' && $data['discount_amount_type'] == 'percentage') {
            $data['percentage_discount_value'] =  ($data['discount'] / 100) * ($data['subtotal']);
            $data['total_discount'] = $data['percentage_discount_value'];
            $data['overall_tax_value'] = ($data['tax'] / 100) * ($data['subtotal'] - $data['total_discount']);
        } elseif ($data['discount_type'] == 'before_tax' && $data['discount_amount_type'] == 'fixed_amount') {
            $data['total_discount'] = $data['fixed_discount'];
            $data['overall_tax_value'] = ($data['tax'] / 100) * ($data['subtotal'] - $data['total_discount']);
        } elseif ($data['discount_type'] == 'after_tax' && $data['discount_amount_type'] == 'percentage') {
            $data['overall_tax_value'] = ($data['tax'] / 100) * ($data['subtotal']);
            $data['percentage_discount_value'] =  ($data['discount'] / 100) * ($data['subtotal'] + $data['overall_tax_value']);
            $data['total_discount'] = $data['percentage_discount_value'];
        } elseif ($data['discount_type'] == 'after_tax' && $data['discount_amount_type'] == 'fixed_amount') {
            $data['overall_tax_value'] = ($data['tax'] / 100) * ($data['subtotal']);
            $data['total_discount'] = $data['fixed_discount'];
        }
        $data['total_tax'] =  $data['overall_tax_value'] +   $data['items_tax_value'];
        
        // Calculate final total: subtotal + total_tax - total_discount + adjustment
        $adjustment = isset($data['adjustment']) ? (float)$data['adjustment'] : 0;
        $data['total'] = $data['subtotal'] + $data['total_tax'] - ($data['total_discount'] ?? 0) + $adjustment;

        $data['created_by'] = Auth::id();
        
        // Backward compatibility: set user_id if it exists in the database
        $data['user_id'] = Auth::id();
        
        // Set payment_currency to match currency for backward compatibility
        $data['payment_currency'] = $data['currency'] ?? 'EGP';
        
        // Set default sale_agent if not provided
        $data['sale_agent'] = $data['sale_agent'] ?? Auth::user()->name ?? 'Admin';
        
        // Set default values for required fields that might be null
        if (empty($data['task_id'])) {
            // Create a default task if none provided
            $data['task_id'] = 1; // Assuming task with ID 1 exists
        }
        if (empty($data['project_id'])) {
            $data['project_id'] = null;
        }
        
        $invoice->fill($data);
        if ($data['client_id']) {
            $client_name = Client::find($data['client_id'])->name;
            $invoice->client_name = $client_name;
        }
        $invoice->save();
        return $invoice;
    }

    public function update($id, $data, array $financeItems = [])
    {
        $invoice = Invoice::findOrFail($id);

        // Calculate invoice totals
        $subtotal = 0;
        $totalTax = 0;
        $validItems = array_filter($financeItems, function ($item) {
            return !is_null($item['name']) && !is_null($item['amount']);
        });
        foreach ($validItems as $item) {
            $qty = isset($item['qty']) ? (float)$item['qty'] : 1;
            $amount = isset($item['amount']) ? (float)$item['amount'] : 0;
            $tax = isset($item['tax']) ? ((float)$item['tax'] / 100) *  $amount  : 0;
            $subtotal += $qty * ($amount + $tax);
            $totalTax += $tax * $qty;
        }
        $data['subtotal'] = $subtotal;
        $data['items_tax_value'] = $totalTax;

        if ($data['discount_type'] == 'before_tax' && $data['discount_amount_type'] == 'percentage') {
            $data['percentage_discount_value'] =  ($data['discount'] / 100) * ($data['subtotal']);
            $data['total_discount'] = $data['percentage_discount_value'];
            $data['overall_tax_value'] = ($data['tax'] / 100) * ($data['subtotal'] - $data['total_discount']);
        } elseif ($data['discount_type'] == 'before_tax' && $data['discount_amount_type'] == 'fixed_amount') {
            $data['total_discount'] = $data['fixed_discount'];
            $data['overall_tax_value'] = ($data['tax'] / 100) * ($data['subtotal'] - $data['total_discount']);
        } elseif ($data['discount_type'] == 'after_tax' && $data['discount_amount_type'] == 'percentage') {
            $data['overall_tax_value'] = ($data['tax'] / 100) * ($data['subtotal']);
            $data['percentage_discount_value'] =  ($data['discount'] / 100) * ($data['subtotal'] + $data['overall_tax_value']);
            $data['total_discount'] = $data['percentage_discount_value'];
        } elseif ($data['discount_type'] == 'after_tax' && $data['discount_amount_type'] == 'fixed_amount') {
            $data['overall_tax_value'] = ($data['tax'] / 100) * ($data['subtotal']);
            $data['total_discount'] = $data['fixed_discount'];
        }
        $data['total_tax'] =  $data['overall_tax_value'] +   $data['items_tax_value'];

        if ($data['client_id']) {
            $client_name = Client::find($data['client_id'])->name;
            $invoice->client_name = $client_name;
        }

        $invoice->update($data);
        return $invoice;
    }

    public function delete($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
    }
}
