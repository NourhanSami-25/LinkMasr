<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\client\Client;
use App\Models\finance\Invoice;
use App\Models\finance\CreditNote;
use App\Models\finance\PaymentRequest;
use App\Services\client\ClientService;
use App\Http\Requests\client\ClientRequest;
use App\Services\reminder\AutoReminderService;
use App\Models\setting\Currency;
use Exception;

use Illuminate\Support\Facades\DB;


class ClientController extends Controller
{

    protected $clientService;
    protected $clientFunctionController;

    public function __construct(ClientService $clientService, ClientFunctionController $clientFunctionController)
    {
        $this->clientService = $clientService;
        $this->clientFunctionController = $clientFunctionController;
    }

    public function index()
    {
        $this->authorize('accessclient', ['view']);
        $clients = $this->clientService->getAll()->reverse();
        return view('client.index', compact('clients'));
    }


    public function create()
    {
        $this->authorize('accessclient', ['create']);
        $currencies = Currency::select('code')->get();
        return view('client.create', compact('currencies'));
    }


    public function store(ClientRequest $request)
    {
        try {

            $client = $this->clientService->create($request->validated());
            AutoReminderService::create('client', 'client', $client);
            return redirect()->route('clients.show', $client->id)->with('success', 'Client Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accessclient', ['details']);
        $client = $this->clientService->getItemById($id);
        $invoices = $this->clientFunctionController->getInvoices($id);
        $paymentRequests = $this->clientFunctionController->getPaymentRequests($id);
        $creditNotes = $this->clientFunctionController->getCreditNotes($id);
        $expenses = $this->clientFunctionController->getExpenses($id);
        $pyments = $this->clientFunctionController->getPayments($id);

        $invoicesTotals = $this->clientFunctionController->getInvoiceTotals($id);
        $creditNotesTotals = $this->clientFunctionController->getCreditNotesTotals($id);
        $expensesTotals = $this->clientFunctionController->getExpensesTotals($id);
        $paymentRequestsTotals = $this->clientFunctionController->getPaymentRequestsTotals($id);
        $pymentsTotals = $this->clientFunctionController->getPymentsTotals($id);

        $contracts = $this->clientFunctionController->getContracts($id);
        $proposals = $this->clientFunctionController->getProposals($id);
        $leads = $this->clientFunctionController->getLeads($id);

        $projects = $this->clientFunctionController->getProjects($id);
        $tasks = $this->clientFunctionController->getTasks($id);


        $notes = $this->clientFunctionController->getNotes($client);
        $POAFiles = $this->clientFunctionController->getPOA($client);
        $IDFiles = $this->clientFunctionController->getIds($client);
        $IPANFiles = $this->clientFunctionController->getIPAN($client);
        $clientContacts = $this->clientFunctionController->getContacts($client);
        $billingAddresses = $this->clientFunctionController->getBillingAddresses($client);
        $ClientAddresses = $this->clientFunctionController->getAddresses($client);
        $files = $this->clientFunctionController->getFiles($client);

        return view('client.show', compact(
            'client',
            'invoices',
            'paymentRequests',
            'creditNotes',
            'expenses',
            'pyments',
            'invoicesTotals',
            'creditNotesTotals',
            'expensesTotals',
            'paymentRequestsTotals',
            'pymentsTotals',
            'contracts',
            'proposals',
            'leads',
            'projects',
            'tasks',
            'notes',
            'POAFiles',
            'IDFiles',
            'IPANFiles',
            'clientContacts',
            'billingAddresses',
            'ClientAddresses',
            'files'
        ) + [
            'invoiceCount' => $invoices->count(),
            'paymentRequestsCount' => $paymentRequests->count(),
            'creditNotesCount' => $creditNotes->count(),
            'expensesCount' => $expenses->count(),
            'paymentsCount' => $pyments->count(),
            'contractsCount' => $contracts->count(),
            'proposalsCount' => $proposals->count(),
            'leadsCount' => $leads->count(),
            'projectsCount' => $projects->count(),
            'tasksCount' => $tasks->count(),

            'poaCount' => $POAFiles->count(),
            'idCount' => $IDFiles->count(),
            'ipanCount' => $IPANFiles->count(),
            'filesCount' => $files->count(),
            'contactsCount' => $clientContacts->count(),
            'notesCount' => $notes->count(),

        ]);
    }



    public function edit($id)
    {
        $this->authorize('accessclient', ['modify']);
        $client = Client::findOrFail($id);
        $currencies = Currency::select('code')->get();
        return view('client.edit', compact('client','currencies'));
    }



    public function update(ClientRequest $request, $id)
    {
        try {
            $client = $this->clientService->update($id, $request->validated());
            AutoReminderService::update($client);
            return redirect()->route('clients.show', $client->id)->with('success', 'Client Updated Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function destroy($id)
    {
        try {
            $this->authorize('accessclient', ['delete']);
            $this->clientService->delete($id);
            return redirect()->route('clients.index')->with('success', 'Client Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
