<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\setting\CompanyProfile;

class ExchangeRate extends Model
{
    protected $fillable = [
        'currency',
        'rate',
    ];

    /**
     * Convert a given amount from the specified currency to the company base currency.
     *
     * @param float|int $amount
     * @param string $currency
     * @return float
     */
    public static function toBaseCurrency($amount, $currency)
    {
        // Get base currency from company profile, fallback to EGP
        $baseCurrency = CompanyProfile::first()->currency ?? 'EGP';

        // If the same currency, return as is
        if (strtoupper($currency) === strtoupper($baseCurrency)) {
            return $amount;
        }

        // Get the exchange rate (rate = how many baseCurrency units for 1 of given currency)
        $rate = self::where('currency', strtoupper($currency))->value('rate');

        // If rate not found, fallback to amount
        if (!$rate) {
            return $amount;
        }

        return $amount * $rate;
    }

    /**
     * Get the current exchange rate for a currency.
     *
     * @param string $currency
     * @return float|null
     */
    public static function getRate($currency)
    {
        return self::where('currency', strtoupper($currency))->value('rate');
    }

}
