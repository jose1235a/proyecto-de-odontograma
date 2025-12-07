<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\AppointmentHistoryService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AppointmentHistoryController extends Controller
{
    public function __construct(
        private AppointmentHistoryService $appointmentHistoryService
    ) {}

    public function index(Request $request): View
    {
        $appointmentHistories = $this->appointmentHistoryService->getPaginated($request);

        return view('dental_management.appointment_history.index', compact('appointmentHistories'));
    }

    public function show($appointmentHistory): View
    {
        $appointmentHistory = $this->appointmentHistoryService->find($appointmentHistory);

        return view('dental_management.appointment_history.show', compact('appointmentHistory'));
    }
}
