<?php

namespace App\Services\setting;

use App\Models\setting\ExchangeRate;
use App\Models\setting\CompanyProfile;


class ExchangeRateService
{
    public function getAll()
    {
        return ExchangeRate::all();
    }

    public function create(array $data)
    {
        // Get default currency
        $defaultCurrency = CompanyProfile::first()->currency ?? 'QAR';
    
        // Example meaning: 1 [currency] = [rate] * [default currency]
        // So just save as is, but ensure data integrity
        return ExchangeRate::create([
            'currency' => strtoupper($data['currency']),
            'rate' => $data['rate'],
            'base_currency' => $defaultCurrency, // optional if you want to store it
        ]);
    }

    public function update($id, $data)
    {
        $exchangeRate = ExchangeRate::findOrFail($id);
        $exchangeRate->update($data);
        return $exchangeRate;
    }

    public function delete($id)
    {
        $exchangeRate = ExchangeRate::findOrFail($id);
        $exchangeRate->delete();
    }
}
