<?php

namespace App\Services\finance;
use Illuminate\Support\Facades\Auth;
use App\Models\finance\Expense;
use App\Models\client\Client;

class ExpenseService
{
    public function getAll()
    {
        $authUser = auth()->user();
        if ($authUser->isAdmin() || $authUser->hasAccess('expense', 'full') || $authUser->hasAccess('expense', 'view_global')) {
            return Expense::all();
        }
        else
        {
             return Expense::where('created_by' , $authUser->id)->get();
        }
        
    }

    public function create(array $data, array $financeItems = [])
    {
        $expense = new Expense();

        // Calculate expense totals
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
        
        // Calculate final total: subtotal + total_tax - total_discount + adjustment
        $adjustment = isset($data['adjustment']) ? (float)$data['adjustment'] : 0;
        $data['total'] = $data['subtotal'] + $data['total_tax'] - ($data['total_discount'] ?? 0) + $adjustment;

        $data['created_by'] = Auth::id();
        $expense->fill($data);
        if ($data['client_id']) {
            $client_name = Client::find($data['client_id'])->name;
            $expense->client_name = $client_name;
        }

        $expense->save();
        return $expense;
    }

    public function update($id, $data, array $financeItems = [])
    {
        $expense = Expense::findOrFail($id);

        // Calculate expense totals
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
        
        // Calculate final total: subtotal + total_tax - total_discount + adjustment
        $adjustment = isset($data['adjustment']) ? (float)$data['adjustment'] : 0;
        $data['total'] = $data['subtotal'] + $data['total_tax'] - ($data['total_discount'] ?? 0) + $adjustment;

        if ($data['client_id']) {
            $client_name = Client::find($data['client_id'])->name;
            $expense->client_name = $client_name;
        }

        $expense->update($data);
        return $expense;
    }

    public function delete($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
    }
}
