<?php

namespace App\Http\Controllers\business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\business\Lead;


class LeadFunctionController extends Controller
{
    public function calculate_lead_number()
    {
        $lastLead = Lead::orderBy('id', 'desc')->first();
        $nextLeadNumber = $lastLead ? $lastLead->number + 1 : 1;
        return $nextLeadNumber;
    }
    
}
