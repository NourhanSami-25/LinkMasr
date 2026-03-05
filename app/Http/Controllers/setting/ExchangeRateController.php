<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\Currency;
use App\Models\setting\ExchangeRate;
use App\Services\setting\ExchangeRateService;
use App\Http\Requests\setting\ExchangeRateRequest;
use Illuminate\Http\Request;
use Exception;

class ExchangeRateController extends Controller
{
     protected $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function index()
    {
        $this->authorize('accesssetting', ['view']);
        $exchangeRates = $this->exchangeRateService->getAll();
        return view('setting.exchange_rate.index', compact('exchangeRates'));
    }


    public function create()
    {
        $this->authorize('accesssetting', ['create']);
        $currencies = Currency::select('code')->get();
        $companyProfile = \App\Models\setting\CompanyProfile::first();
        return view('setting.exchange_rate.create', compact('currencies', 'companyProfile'));
    }


    public function store(ExchangeRateRequest $request)
    {
        try {
            $exchangeRate = $this->exchangeRateService->create($request->validated());
            return redirect()->route('exchangeRates.index')->with('success', 'ExchangeRate Created Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit($id)
    {
        $this->authorize('accesssetting', ['modify']);
        $exchangeRate = ExchangeRate::findOrFail($id);
        $currencies = Currency::select('code')->get();
        $companyProfile = \App\Models\setting\CompanyProfile::first();
        return view('setting.exchange_rate.edit', compact('exchangeRate' , 'currencies', 'companyProfile'));
    }


    public function update(ExchangeRateRequest $request, $id)
    {
        try {
            $exchangeRate = $this->exchangeRateService->update($id, $request->validated());
            return redirect()->route('exchangeRates.index')->with('success', 'ExchangeRate updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function destroy($id)
    {
        try {
            $this->authorize('accesssetting', ['delete']);
            $this->exchangeRateService->delete($id);
            return redirect()->route('exchangeRates.index')->with('success', 'ExchangeRate Deleted Successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
