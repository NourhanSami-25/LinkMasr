<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\setting\Currency;
use App\Services\setting\CurrencyService;
use App\Http\Requests\setting\CurrencyRequest;
use Exception;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $this->authorize('accesssetting', ['view']);
        $currencies = $this->currencyService->getAll();
        return view('setting.currency.index', compact('currencies'));
    }


    public function create()
    {
        $this->authorize('accesssetting', ['create']);
        return view('setting.currency.create');
    }


    public function store(CurrencyRequest $request)
    {
        try {
            $currency = $this->currencyService->create($request->validated());
            return redirect()->route('currencies.index')->with('success', 'Currency Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function show($id)
    {
        $this->authorize('accesssetting', ['details']);
    }



    public function edit($id)
    {
        $this->authorize('accesssetting', ['modify']);
        $currency = Currency::findOrFail($id);
        return view('setting.currency.edit', compact('currency'));
    }



    public function update(CurrencyRequest $request, $id)
    {
        try {
            $currency = $this->currencyService->update($id, $request->validated());
            return redirect()->route('currencies.index')->with('success', 'Currency updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accesssetting', ['delete']);
            $this->currencyService->delete($id);
            return redirect()->route('currencies.index')->with('success', 'Currency Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
