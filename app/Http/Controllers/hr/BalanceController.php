<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Services\hr\BalanceService;
use App\Http\Requests\hr\BalanceRequest;
use Illuminate\Http\Request;
use App\Models\hr\Balance;
use App\Models\hr\Department;
use Exception;


class BalanceController extends Controller
{
    protected $balanceService;

    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    public function index()
    {
        $balances = $this->balanceService->getAll();
        $departments = Department::select('id', 'subject')->get();
        return view('hr.balance.index', compact('balances','departments'));
    }

    public function create()
    {
        return view('hr.balance.index');
    }

    public function store(BalanceRequest $request)
    {
        try {
            $this->balanceService->create($request->validated());
            return redirect()->route('balances.index')->with('success', 'Balance created successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function edit($id)
    {
        $balance = Balance::findOrFail($id);
        return view('hr.balance.edit', compact('balance'));
    }

    public function update(BalanceRequest $request, $id)
    {
        try {
            $this->balanceService->update($id, $request->validated());
            return redirect()->route('balances.index')->with('success', 'Balance updated successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $this->balanceService->delete($id);
            return redirect()->back()->with('success', 'Balance deleted successfully');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
