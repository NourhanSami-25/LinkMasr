<?php

namespace App\Services\setting;

use App\Models\setting\Currency;

class CurrencyService
{
    public function getAll()
    {
        return Currency::all();
    }

    public function create(array $data)
    {
        return Currency::create($data);
    }

    public function update($id, $data)
    {
        $currency = Currency::findOrFail($id);
        $currency->update($data);
        return $currency;
    }

    public function delete($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
    }
}
