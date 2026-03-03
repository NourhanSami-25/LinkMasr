<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\hr\RequestReportService;

class RequestReportController extends Controller
{
    protected $reportService;

    public function __construct(RequestReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function requests_reports(Request $request)
    {
        $requestType = $request->get('type');
        $requests = $this->reportService->getRequests($requestType);
        return view('hr.report.requests', compact('requests', 'requestType'));
    }
}
