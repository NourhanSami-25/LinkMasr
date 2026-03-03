<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\client\Client;
use App\Models\finance\Invoice;
use App\Models\finance\CreditNote;
use App\Models\finance\PaymentRequest;
use App\Services\client\ClientService;
use App\Http\Requests\client\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\project\Project;
use App\Models\task\Task;


use App\Models\common\Note;
use App\Models\common\File;
use App\Models\common\Reminder;

use App\Models\client\BillingAddress;
use App\Models\client\ClientContact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Collection;
use App\Models\setting\ExchangeRate;
use App\Models\setting\CompanyProfile;

class ClientFunctionController extends Controller
{

    protected $clientService;
    protected $clientFunctionController;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function disable($id)
    {
        $this->authorize('accessclient', ['modify']);
        $client = Client::findOrFail($id);
        $client->status = 'disabled';
        $client->save();
        return redirect()->back()->with('success', 'Client is disabled successfully');
    }

    public function activate($id)
    {
        $this->authorize('accessclient', ['modify']);
        $client = Client::findOrFail($id);
        $client->status = 'active';
        $client->save();
        return redirect()->back()->with('success', 'Client is activated successfully');
    }

    public function getInvoices($clientId)
    {
        $this->authorize('accessclient', ['details']);
        $invoices =  DB::table('invoices')
            ->leftJoin('projects', 'invoices.project_id', '=', 'projects.id')
            ->leftJoin('tasks', 'invoices.task_id', '=', 'tasks.id')
            ->where('invoices.client_id', $clientId) // Direct invoice to client
            ->orWhere('projects.client_id', $clientId) // Invoice via project
            ->orWhere('tasks.client_id', $clientId) // Invoice via task  
            ->select('invoices.*')
            ->get();
        return $invoices;
    }

    public function getPaymentRequests($clientId)
    {
        $paymentRequests = DB::table('paymentrequests')
            ->leftJoin('projects', 'paymentrequests.project_id', '=', 'projects.id')
            ->leftJoin('tasks', 'paymentrequests.task_id', '=', 'tasks.id')
            ->where('paymentrequests.client_id', $clientId) // Direct invoice to client
            ->orWhere('projects.client_id', $clientId) // Invoice via project
            ->orWhere('tasks.client_id', $clientId) // Invoice via task  
            ->select('paymentrequests.*')
            ->get();
        return $paymentRequests;
    }

    public function getCreditNotes($clientId)
    {
        $creditNotes = DB::table('creditnotes')
            ->leftJoin('projects', 'creditnotes.project_id', '=', 'projects.id')
            ->leftJoin('tasks', 'creditnotes.task_id', '=', 'tasks.id')
            ->where('creditnotes.client_id', $clientId) // Direct invoice to client
            ->orWhere('projects.client_id', $clientId) // Invoice via project
            ->orWhere('tasks.client_id', $clientId) // Invoice via task  
            ->select('creditnotes.*')
            ->get();
        return $creditNotes;
    }

    public function getExpenses($clientId)
    {
        $expenses = DB::table('expenses')
            ->leftJoin('projects', 'expenses.project_id', '=', 'projects.id')
            ->leftJoin('tasks', 'expenses.task_id', '=', 'tasks.id')
            ->where('expenses.client_id', $clientId) // Direct invoice to client
            ->orWhere('projects.client_id', $clientId) // Invoice via project
            ->orWhere('tasks.client_id', $clientId) // Invoice via task  
            ->select('expenses.*')
            ->get();
        return $expenses;
    }

    public function getPayments($clientId)
    {
        $payments = DB::table('pyments')
            ->leftJoin('projects', 'pyments.project_id', '=', 'projects.id')
            ->leftJoin('tasks', 'pyments.task_id', '=', 'tasks.id')
            ->leftJoin('invoices', 'pyments.invoice_id', '=', 'invoices.id')
            ->leftJoin('creditnotes', 'pyments.creditNote_id', '=', 'creditnotes.id')
            ->where('pyments.client_id', $clientId) // Direct payment to client
            ->orWhere('projects.client_id', $clientId) // Payment via project
            ->orWhere('tasks.client_id', $clientId) // Payment via task  
            ->orWhere('invoices.client_id', $clientId) // Payment via invoice  
            ->orWhere('creditnotes.client_id', $clientId) // Payment via creditnote  
            ->select('pyments.*')
            ->get();

        return $payments;
    }

    public function getContracts($clientId)
    {
        $contracts = DB::table('contracts')
            ->leftJoin('projects', 'contracts.project_id', '=', 'projects.id')
            ->leftJoin('tasks', 'contracts.task_id', '=', 'tasks.id')
            ->where('contracts.client_id', $clientId) // Direct contract to client
            ->orWhere('projects.client_id', $clientId) // Contract via project
            ->orWhere('tasks.client_id', $clientId) // Contract via task  
            ->select('contracts.*')
            ->get();

        return $contracts;
    }
    public function getProposals($clientId)
    {
        $proposals = DB::table('proposals')
            ->leftJoin('projects', 'proposals.project_id', '=', 'projects.id')
            ->leftJoin('tasks', 'proposals.task_id', '=', 'tasks.id')
            ->where('proposals.client_id', $clientId) // Direct proposal to client
            ->orWhere('projects.client_id', $clientId) // Proposal via project
            ->orWhere('tasks.client_id', $clientId) // Proposal via task  
            ->select('proposals.*')
            ->get();

        return $proposals;
    }

    public function getLeads($clientId)
    {
        $leads = DB::table('leads')
            ->leftJoin('projects', 'leads.project_id', '=', 'projects.id')
            ->leftJoin('tasks', 'leads.task_id', '=', 'tasks.id')
            ->where('leads.client_id', $clientId) // Direct lead to client
            ->orWhere('projects.client_id', $clientId) // Lead via project
            ->orWhere('tasks.client_id', $clientId) // Lead via task  
            ->select('leads.*')
            ->get();

        return $leads;
    }


    public function getProjects($clientId)
    {
        $projects = Project::where('client_id', $clientId)->get();
        return $projects;
    }


    public function getTasks($clientId)
    {
        $tasks = Task::where('client_id', $clientId)->get();
        return $tasks;
    }



    public function getNotes($client)
    {
        $notes = $client->notes()->get();
        return $notes;
    }


    public function getFiles($client)
    {
        $files = $client->files()->get();
        return $files;
    }


    public function getBillingAddresses($client)
    {
        $billingAddresses = $client->billingAddresses()->get();
        return $billingAddresses;
    }

    public function getAddresses($client)
    {
        $ClientAddress = $client->address()->get();
        return $ClientAddress;
    }


    public function getPOA($client)
    {
        $files = $client->files()->where('category', 'poa')->get();
        return $files;
    }


    public function getIds($client)
    {
        $files = $client->files()->where('category', 'ids')->get();
        return $files;
    }

    public function getIPAN($client)
    {
        $files = $client->files()->where('category', 'ipan')->get();
        return $files;
    }


    public function getContacts($client)
    {
        $clientContacts = $client->clientContacts()->get();
        return $clientContacts;
    }



    public function getInvoiceTotals($clientId)
    {
        // Get all invoices from getInvoices() method
        $invoices = $this->getInvoices($clientId);

        // Initialize totals
        $invoicesTotals = [
            'paid' => 0,
            'unpaid' => 0,
            'partially_paid' => 0,
            'draft' => 0,
        ];

        // Loop through invoices and calculate totals
        foreach ($invoices as $invoice) {
            if ($invoice->status === 'paid') {
                $invoicesTotals['paid'] += $this->calculate_total($invoice->total , $invoice->currency);
            } elseif ($invoice->status === 'unpaid') {
                $invoicesTotals['unpaid'] += $this->calculate_total($invoice->total , $invoice->currency);
            } elseif ($invoice->status === 'partially_paid') {
                $invoicesTotals['partially_paid'] += $this->calculate_total($invoice->total , $invoice->currency);
            } elseif ($invoice->status === 'draft') {
                $invoicesTotals['draft'] += $this->calculate_total($invoice->total , $invoice->currency);
            }
        }

        return $invoicesTotals;
    }

    public function getCreditNotesTotals($clientId)
    {
        // Get all creditNotes from getCreditNotes() method
        $creditNotes = $this->getCreditNotes($clientId);

        $creditNotesTotals = [
            'paid' => 0,
            'unpaid' => 0,
            'partially_paid' => 0,
            'draft' => 0,
        ];

        // Loop through creditNote and calculate totals
        foreach ($creditNotes as $creditNote) {
            if ($creditNote->status === 'paid') {
                $creditNotesTotals['paid'] += $this->calculate_total($creditNote->total , $creditNote->currency);
            } elseif ($creditNote->status === 'unpaid') {
                $creditNotesTotals['unpaid'] += $this->calculate_total($creditNote->total , $creditNote->currency);
            } elseif ($creditNote->status === 'partially_paid') {
                $creditNotesTotals['partially_paid'] += $this->calculate_total($creditNote->total , $creditNote->currency);
            } elseif ($creditNote->status === 'draft') {
                $creditNotesTotals['draft'] += $this->calculate_total($creditNote->total , $creditNote->currency);
            }
        }

        return $creditNotesTotals;
    }

    public function getExpensesTotals($clientId)
    {
        // Get all expenses from getExpensesTotals() method
        $expenses = $this->getExpenses($clientId);

        $baseCurrency = CompanyProfile::first()->currency ?? 'QAR';

        // Initialize totals
        $getExpensesTotals = [
            'paid' => 0,
            'unpaid' => 0,
            'partially_paid' => 0,
            'draft' => 0,
        ];

        // Loop through expense and calculate totals
        foreach ($expenses as $expense) {

            if (strtoupper($expense->currency) === strtoupper($baseCurrency)) {
                    $convertedTotal = $expense->total;
            } 
            else {
                    // if rate not found, keep original
                    $rate = ExchangeRate::where('currency', $expense->currency)->value('rate');
                    $convertedTotal = $rate ? $expense->total * $rate : $expense->total;
            }


            if ($expense->status === 'paid') {
                $getExpensesTotals['paid'] += $this->calculate_total($expense->total , $expense->currency);
            } elseif ($expense->status === 'unpaid') {
                $getExpensesTotals['unpaid'] += $this->calculate_total($expense->total , $expense->currency);
            } elseif ($expense->status === 'draft') {
                $getExpensesTotals['draft'] += $this->calculate_total($expense->total , $expense->currency);
            }
        }

        return $getExpensesTotals;
    }

    public function getPaymentRequestsTotals($clientId)
    {
        // Get all invoices from getInvoices() method
        $paymentRequests = $this->getPaymentRequests($clientId);

        $baseCurrency = CompanyProfile::first()->currency ?? 'QAR';

        // Initialize totals
        $paymentRequestsTotals = [
            'sent' => 0,
            'accepted' => 0,
            'declined' => 0,
            'expired' => 0,
            'draft' => 0,
        ];

        // Loop through invoices and calculate totals
        foreach ($paymentRequests as $paymentRequest) {

            if (strtoupper($paymentRequest->currency) === strtoupper($baseCurrency)) {
                    $convertedTotal = $paymentRequest->total;
            } 
            else {
                    // if rate not found, keep original
                    $rate = ExchangeRate::where('currency', $paymentRequest->currency)->value('rate');
                    $convertedTotal = $rate ? $paymentRequest->total * $rate : $paymentRequest->total;
            }


            if ($paymentRequest->status === 'sent') {
                $paymentRequestsTotals['sent'] += $this->calculate_total($paymentRequest->total , $paymentRequest->currency);
            } elseif ($paymentRequest->status === 'accepted') {
                $paymentRequestsTotals['accepted'] += $this->calculate_total($paymentRequest->total , $paymentRequest->currency);
            } elseif ($paymentRequest->status === 'declined') {
                $paymentRequestsTotals['declined'] += $this->calculate_total($paymentRequest->total , $paymentRequest->currency);
            } elseif ($paymentRequest->status === 'expired') {
                $paymentRequestsTotals['expired'] += $this->calculate_total($paymentRequest->total , $paymentRequest->currency);
            } elseif ($paymentRequest->status === 'draft') {
                $paymentRequestsTotals['draft'] += $this->calculate_total($paymentRequest->total , $paymentRequest->currency);
            }
        }

        return $paymentRequestsTotals;
    }

    public function getPymentsTotals($clientId)
    {
        // Get all pyments from getPymentsTotals() method
        $pyments = $this->getPayments($clientId);

        $baseCurrency = CompanyProfile::first()->currency ?? 'QAR';

        // Initialize totals
        $getPymentsTotals = [
            'paid' => 0,
            'draft' => 0,
        ];

        // Loop through pyment and calculate totals
        foreach ($pyments as $pyment) {

            if (strtoupper($pyment->currency) === strtoupper($baseCurrency)) {
                    $convertedTotal = $pyment->total;
            } 
            else {
                    // if rate not found, keep original
                    $rate = ExchangeRate::where('currency', $pyment->currency)->value('rate');
                    $convertedTotal = $rate ? $pyment->total * $rate : $pyment->total;
            }


            if ($pyment->status === 'paid') {
                $getPymentsTotals['paid'] += $this->calculate_total($pyment->total , $pyment->currency);
            } elseif ($pyment->status === 'draft') {
                $getPymentsTotals['draft'] += $this->calculate_total($pyment->total , $pyment->currency);
            }
        }

        return $getPymentsTotals;
    }


    public function statment($id, Request $request)
    {
        $client = $this->clientService->getItemById($id);

        $date_filter = $request->input('date_filter');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query_filter = function($query) use ($date_filter, $start_date, $end_date) {
            if ($date_filter == 'today') {
                $query->whereDate('date', Carbon::today());
            } elseif ($date_filter == 'week') {
                $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($date_filter == 'month') {
                $query->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year);
            } elseif ($date_filter == 'year') {
                $query->whereYear('date', Carbon::now()->year);
            } elseif ($date_filter == 'custom' && $start_date && $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            }
        };

        $invoices = Invoice::where('client_id', $id)->where($query_filter)->get();
        $paymentRequests = PaymentRequest::where('client_id', $id)->where($query_filter)->get();
        $creditNotes = CreditNote::where('client_id', $id)->where($query_filter)->get();
        $expenses = Expense::where('client_id', $id)->where($query_filter)->get();
        $payments = Pyment::where('client_id', $id)->where($query_filter)->get();

        $proposals = 0;
        $contracts = 0;

        $current_balance = 0;
        $debit_balance = 0;
        $credit_balance = 0;
        $overdue_balance = 0;
        $balance_status = true;

        $projects = 0;
        $tasks = 0;
        $cases = 0;
        $tickets = 0;
        $contacts = 0;
        $notes = 0;
        $files = 0;
        $reminders = 0;


        $invoiceStatusData = [
            'paid' => ['count' => 0, 'total' => 0],
            'unpaid' => ['count' => 0, 'total' => 0],
            'partially' => ['count' => 0, 'total' => 0],
            'overdue' => ['count' => 0, 'total' => 0],
            'draft' => ['count' => 0, 'total' => 0],
        ];

        $paymentRequestStatusData = [
            'sent' => ['count' => 0, 'total' => 0],
            'accepted' => ['count' => 0, 'total' => 0],
            'expired' => ['count' => 0, 'total' => 0],
            'declined' => ['count' => 0, 'total' => 0],
            'draft' => ['count' => 0, 'total' => 0],
        ];

        $creditNoteStatusData = [
            'paid' => ['count' => 0, 'total' => 0],
            'unpaid' => ['count' => 0, 'total' => 0],
            'partially' => ['count' => 0, 'total' => 0],
            'draft' => ['count' => 0, 'total' => 0],
        ];

        $expenseStatusData = [
            'paid' => ['count' => 0, 'total' => 0],
            'unpaid' => ['count' => 0, 'total' => 0],
            'partially' => ['count' => 0, 'total' => 0],
            'draft' => ['count' => 0, 'total' => 0],
        ];

        $paymentStatusData = [
            'paid' => ['count' => 0, 'total' => 0],
            'draft' => ['count' => 0, 'total' => 0],
        ];

        foreach ($invoices as $item) {
            $status = $item->status;
            if (isset($invoiceStatusData[$status])) {
                $invoiceStatusData[$status]['count'] += 1;
                $invoiceStatusData[$status]['total'] += $this->calculate_total($item->total , $item->currency);
            }
        }

        foreach ($paymentRequests as $item) {
            $status = $item->status;
            if (isset($paymentRequestStatusData[$status])) {
                $paymentRequestStatusData[$status]['count'] += 1;
                $paymentRequestStatusData[$status]['total'] += $this->calculate_total($item->total , $item->currency);
            }
        }

        foreach ($creditNotes as $item) {
            $status = $item->status;
            if (isset($creditNoteStatusData[$status])) {
                $creditNoteStatusData[$status]['count'] += 1;
                $creditNoteStatusData[$status]['total'] += $this->calculate_total($item->total , $item->currency);
            }
        }

        foreach ($expenses as $item) {
            $status = $item->status;
            if (isset($expenseStatusData[$status])) {
                $expenseStatusData[$status]['count'] += 1;
                $expenseStatusData[$status]['total'] += $this->calculate_total($item->total , $item->currency);
            }
        }

        foreach ($payments as $item) {
            $status = $item->status;
            if (isset($paymentStatusData[$status])) {
                $paymentStatusData[$status]['count'] += 1;
                $paymentStatusData[$status]['total'] += $this->calculate_total($item->total , $item->currency);
            }
        }


        

        $debit_balance = $invoiceStatusData['unpaid']['total'] +  $invoiceStatusData['overdue']['total'] +  $invoiceStatusData['paid']['total'];
        $credit_balance = $creditNoteStatusData['paid']['total'] + $invoiceStatusData['paid']['total'];
        $actually_paid = $paymentStatusData['paid']['total'];
        $current_balance =  $credit_balance - $debit_balance;

        if ($credit_balance != $actually_paid)
            $balance_status = false;



        return view(
            'client.statment',
            compact(
                'client',
                'invoices',
                'paymentRequests',
                'creditNotes',
                'expenses',
                'payments',
                'proposals',
                'contracts',
                'current_balance',
                'debit_balance',
                'credit_balance',
                'actually_paid',
                'balance_status',
                'projects',
                'tasks',
                'cases',
                'tickets',
                'contacts',
                'notes',
                'files',
                'reminders',
                'invoiceStatusData',
                'paymentRequestStatusData',
                'creditNoteStatusData',
                'expenseStatusData',
                'paymentStatusData'
            )
        );
    }


    public function calculate_total($total , $currency){
        $baseCurrency = CompanyProfile::first()->currency ?? 'QAR';
        $rate = ExchangeRate::where('currency', $currency)->value('rate');
        $convertedTotal = 0;
        if (strtoupper($currency) === strtoupper($baseCurrency)) {
                $convertedTotal = $total;
            } 
        else {
                // if rate not found, keep original
                $rate = ExchangeRate::where('currency', $currency)->value('rate');
                $convertedTotal = $rate ? $total * $rate : $total;
        }

        return $convertedTotal;

    }

    public function printStatment($id, Request $request)
    {
        $data = $this->statment($id, $request);
        // If statment returns a view, we need the data instead. 
        // Let's refactor to a private method or just copy logic.
        // For simplicity, I'll extract common data and return a different view.
        return view('client.print_statment', $data->getData());
    }


}
