<?php

namespace App\Http\Controllers\business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\business\Contract;


class ContractFunctionController extends Controller
{
    public function calculate_contract_number()
    {
        $lastContract = Contract::orderBy('id', 'desc')->first();
        $nextContractNumber = $lastContract ? $lastContract->number + 1 : 1;
        return $nextContractNumber;
    }
}
