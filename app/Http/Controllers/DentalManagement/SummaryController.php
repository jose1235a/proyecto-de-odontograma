<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\SummaryService;
use Illuminate\View\View;

class SummaryController extends Controller
{
    public function __construct(
        private SummaryService $summaryService
    ) {}

    public function index(): View
    {
        $summary = $this->summaryService->getCompleteSummary();

        return view('dental_management.summary.index', compact('summary'));
    }
}
