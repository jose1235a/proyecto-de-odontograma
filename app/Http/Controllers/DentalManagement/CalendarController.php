<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\CalendarService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function __construct(
        private CalendarService $calendarService
    ) {}

    public function index(Request $request): View
    {
        $appointments = $this->calendarService->getAppointmentsForCalendar($request);

        return view('dental_management.calendar.index', compact('appointments'));
    }

    public function events(Request $request)
    {
        $events = $this->calendarService->getCalendarEvents($request);

        return response()->json($events);
    }
}
