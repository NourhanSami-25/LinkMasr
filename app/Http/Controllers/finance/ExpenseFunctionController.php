<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\Expense;


class ExpenseFunctionController extends Controller
{
    public function calculate_expense_number()
    {
        $lastExpense = Expense::orderBy('number', 'desc')->first();
        $nextExpenseNumber = $lastExpense ? $lastExpense->number + 1 : 1;

        // Keep checking until an unused number is found
        while (Expense::where('number', $nextExpenseNumber)->exists()) {
            $nextExpenseNumber++;
        }

        return $nextExpenseNumber;
    }

    public function expense_convert_paid($id)
    {
        $expense = Expense::find($id);
        $expense->status = 'paid';
        $expense->save();
        return redirect()->back()->with('success', 'Expense status changed successfully');
    }

    public function expense_convert_partially_paid($id)
    {
        $expense = Expense::find($id);
        $expense->status = 'partially';
        $expense->save();
        return redirect()->back()->with('success', 'Expense status changed successfully');
    }

    public function expense_convert_unpaid($id)
    {
        $expense = Expense::find($id);
        $expense->status = 'unpaid';
        $expense->save();
        return redirect()->back()->with('success', 'Expense status changed successfully');
    }

    public function expense_convert_draft($id)
    {
        $expense = Expense::find($id);
        $expense->status = 'draft';
        $expense->save();
        return redirect()->back()->with('success', 'Expense status changed successfully');
    }
}
