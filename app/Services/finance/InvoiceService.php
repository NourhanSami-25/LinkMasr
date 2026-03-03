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

        $data['created_by'] = Auth::id();
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
