<?php

namespace App\Services\hr;

use Illuminate\Support\Facades\DB;
use App\Models\hr\Balance;

class BalanceService
{
    public function getAll()
    {
        return Balance::with('user')->orderBy('year', 'desc')->get();
    }

    public function create(array $data)
    {
        return Balance::create($data);
    }

    public function update($id, array $data)
    {
        $balance = Balance::findOrFail($id);
        $balance->update($data);
        return $balance;
    }

    public function delete($id)
    {
        $balance = Balance::findOrFail($id);
        $balance->delete();
    }

    public function deductDays($userId, $year, float $days): bool
    {
        return DB::transaction(function () use ($userId, $year, $days) {
            $balance = Balance::where('user_id', $userId)->where('year', $year)->lockForUpdate()->first();
            if (!$balance || $balance->total_days - $balance->used_days < $days) {
                return false;
            }
            $balance->increment('used_days', $days);
            return true;
        });
    }
}
