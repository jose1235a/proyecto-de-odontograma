<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\ReportsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function __construct(
        private ReportsService $reportsService
    ) {}

    public function index(): View
    {
        $stats = $this->reportsService->getDashboardStats();

        return view('dental_management.reports.index', compact('stats'));
    }

    public function appointments(Request $request)
    {
        $data = $this->reportsService->getAppointmentsReport($request);

        return view('dental_management.reports.appointments', $data);
    }

    public function payments(Request $request)
    {
        $data = $this->reportsService->getPaymentsReport($request);

        return view('dental_management.reports.payments', $data);
    }

    public function patients(Request $request)
    {
        $data = $this->reportsService->getPatientsReport($request);

        return view('dental_management.reports.patients', $data);
    }

    public function exportAppointments(Request $request)
    {
        return $this->reportsService->exportAppointments($request);
    }

    public function exportPayments(Request $request)
    {
        return $this->reportsService->exportPayments($request);
    }

    public function exportPatients(Request $request)
    {
        return $this->reportsService->exportPatients($request);
    }
}
