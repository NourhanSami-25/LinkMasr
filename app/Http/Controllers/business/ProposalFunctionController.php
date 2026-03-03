<?php

namespace App\Http\Controllers\business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\business\Proposal;


class ProposalFunctionController extends Controller
{
    public function calculate_proposal_number()
    {
        $lastProposal = Proposal::orderBy('id', 'desc')->first();
        $nextProposalNumber = $lastProposal ? $lastProposal->number + 1 : 1;
        return $nextProposalNumber;
    }
}
