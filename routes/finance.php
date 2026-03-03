<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\finance\PaymentRequestController;
use App\Http\Controllers\finance\PymentController;
use App\Http\Controllers\finance\InvoiceController;
use App\Http\Controllers\finance\ExpenseController;
use App\Http\Controllers\finance\CreditNoteController;

use App\Http\Controllers\finance\PaymentModeController;
use App\Http\Controllers\finance\ExpenseTypeController;
use App\Http\Controllers\finance\TaxRateController;

use App\Http\Controllers\finance\FinanceFunctionController;
use App\Http\Controllers\finance\InvoiceFunctionController;
use App\Http\Controllers\finance\CreditNoteFunctionController;
use App\Http\Controllers\finance\PaymentRequestFunctionController;
use App\Http\Controllers\finance\ConversionsController;
use App\Http\Controllers\finance\ExpenseFunctionController;
use App\Http\Controllers\finance\PymentFunctionController;

// Main Tables CRUD
Route::resource('invoices', InvoiceController::class);
Route::resource('pyments', PymentController::class);
Route::resource('expenses', ExpenseController::class);
Route::resource('creditNotes', CreditNoteController::class);
Route::resource('paymentRequests', PaymentRequestController::class);

// Secondary Tables CRUD
Route::resource('payment-modes', PaymentModeController::class);
Route::resource('expense-types', ExpenseTypeController::class);
Route::resource('tax-rates', TaxRateController::class);

// Change Invoice Status
Route::get('invoice-convert-paid/{id}', [InvoiceFunctionController::class, 'invoice_convert_paid'])->name('invoice_convert_paid');
Route::get('invoice-convert-partially-paid/{id}', [InvoiceFunctionController::class, 'invoice_convert_partially_paid'])->name('invoice_convert_partially_paid');
Route::get('invoice-convert-unpaid/{id}', [InvoiceFunctionController::class, 'invoice_convert_unpaid'])->name('invoice_convert_unpaid');
Route::get('invoice-convert-overdue/{id}', [InvoiceFunctionController::class, 'invoice_convert_overdue'])->name('invoice_convert_overdue');
Route::get('invoice-convert-draft/{id}', [InvoiceFunctionController::class, 'invoice_convert_draft'])->name('invoice_convert_draft');

// Change CreditNote Status
Route::get('creditNote-convert-paid/{id}', [CreditNoteFunctionController::class, 'creditNote_convert_paid'])->name('creditNote_convert_paid');
Route::get('creditNote-convert-partially-paid/{id}', [CreditNoteFunctionController::class, 'creditNote_convert_partially_paid'])->name('creditNote_convert_partially_paid');
Route::get('creditNote-convert-unpaid/{id}', [CreditNoteFunctionController::class, 'creditNote_convert_unpaid'])->name('creditNote_convert_unpaid');
Route::get('creditNote-convert-overdue/{id}', [CreditNoteFunctionController::class, 'creditNote_convert_overdue'])->name('creditNote_convert_overdue');
Route::get('creditNote-convert-draft/{id}', [CreditNoteFunctionController::class, 'creditNote_convert_draft'])->name('creditNote_convert_draft');

// Change PaymentRequest Status
Route::get('paymentRequest-convert-paid/{id}', [PaymentRequestFunctionController::class, 'paymentRequest_convert_paid'])->name('paymentRequest_convert_paid');
Route::get('paymentRequest-convert-partially-paid/{id}', [PaymentRequestFunctionController::class, 'paymentRequest_convert_partially_paid'])->name('paymentRequest_convert_partially_paid');
Route::get('paymentRequest-convert-unpaid/{id}', [PaymentRequestFunctionController::class, 'paymentRequest_convert_unpaid'])->name('paymentRequest_convert_unpaid');
Route::get('paymentRequest-convert-overdue/{id}', [PaymentRequestFunctionController::class, 'paymentRequest_convert_overdue'])->name('paymentRequest_convert_overdue');
Route::get('paymentRequest-convert-draft/{id}', [PaymentRequestFunctionController::class, 'paymentRequest_convert_draft'])->name('paymentRequest_convert_draft');

// Change Expense Status
Route::get('expense-convert-paid/{id}', [ExpenseFunctionController::class, 'expense_convert_paid'])->name('expense_convert_paid');
Route::get('expense-convert-partially-paid/{id}', [ExpenseFunctionController::class, 'expense_convert_partially_paid'])->name('expense_convert_partially_paid');
Route::get('expense-convert-unpaid/{id}', [ExpenseFunctionController::class, 'expense_convert_unpaid'])->name('expense_convert_unpaid');
Route::get('expense-convert-draft/{id}', [ExpenseFunctionController::class, 'expense_convert_draft'])->name('expense_convert_draft');

// Change Pyment Status
Route::get('pyment-convert-paid/{id}', [PymentFunctionController::class, 'pyment_convert_paid'])->name('pyment_convert_paid');
Route::get('pyment-convert-draft/{id}', [PymentFunctionController::class, 'pyment_convert_draft'])->name('pyment_convert_draft');

// Download PDF & Printing Finance Models
Route::get('invoice-pdf/{id}', [FinanceFunctionController::class, 'invoice_show_pdf'])->name('invoice_show_pdf');
Route::get('paymentRequest-pdf/{id}', [FinanceFunctionController::class, 'paymentRequest_show_pdf'])->name('paymentRequest_show_pdf');
Route::get('creditNote-pdf/{id}', [FinanceFunctionController::class, 'creditNote_show_pdf'])->name('creditNote_show_pdf');
Route::get('expense-pdf/{id}', [FinanceFunctionController::class, 'expense_show_pdf'])->name('expense_show_pdf');
Route::get('pyment-pdf/{id}', [FinanceFunctionController::class, 'pyment_show_pdf'])->name('pyment_show_pdf');


// Conversions
Route::get('invoice-pyment/{id}', [ConversionsController::class, 'convert_invoice_to_pyment'])->name('convert_invoice_to_pyment');
Route::get('expense-pyment/{id}', [ConversionsController::class, 'convert_expense_to_pyment'])->name('convert_expense_to_pyment');
Route::get('expense-invoice/{id}', [ConversionsController::class, 'convert_expense_to_invoice'])->name('convert_expense_to_invoice');
Route::get('creditNote-pyment/{id}', [ConversionsController::class, 'convert_creditNote_to_pyment'])->name('convert_creditNote_to_pyment');
Route::get('paymentRequest-pyment/{id}', [ConversionsController::class, 'convert_paymentRequest_to_pyment'])->name('convert_paymentRequest_to_pyment');
Route::get('paymentRequest-invoice/{id}', [ConversionsController::class, 'convert_paymentRequest_to_invoice'])->name('convert_paymentRequest_to_invoice');
Route::get('paymentRequest-expense/{id}', [ConversionsController::class, 'convert_paymentRequest_to_expense'])->name('convert_paymentRequest_to_expense');
Route::get('invoice-creditNote/{id}', [ConversionsController::class, 'convert_invoice_to_creditNote'])->name('convert_invoice_to_creditNote');



// All Clients Statment
Route::get('/statment', [FinanceFunctionController::class, 'all_clients_statment'])->name('finance.status');
Route::get('/finances-report', [FinanceFunctionController::class, 'finance_report'])->name('finance.report');

