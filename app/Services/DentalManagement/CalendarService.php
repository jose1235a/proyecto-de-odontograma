<?php

namespace App\Services\DentalManagement;

use App\Models\Appointment;
use Illuminate\Http\Request;

class CalendarService
{
    public function getAppointmentsForCalendar(Request $request)
    {
        $start = $request->get('start')
            ? \Carbon\Carbon::parse($request->get('start'))->startOfDay()
            : now()->startOfMonth();
        $end = $request->get('end')
            ? \Carbon\Carbon::parse($request->get('end'))->endOfDay()
            : now()->endOfMonth();

        return Appointment::query()
            ->with(['patient', 'doctor', 'treatment'])
            ->whereBetween('appointment_date', [$start, $end])
            ->notDeleted()
            ->get();
    }

    public function getCalendarEvents(Request $request): array
    {
        $appointments = $this->getAppointmentsForCalendar($request);

        $events = [];

        foreach ($appointments as $appointment) {
            $doctorName = $appointment->doctor ? trim($appointment->doctor->name . ' ' . ($appointment->doctor->last_name ?? '')) : '-';
            $patientName = $appointment->patient ? trim($appointment->patient->name . ' ' . ($appointment->patient->last_name ?? '')) : '-';

            $events[] = [
                'id' => $appointment->id,
                'title' => $patientName,
                'start' => $appointment->appointment_date->format('Y-m-d') . 'T' . $appointment->appointment_time->format('H:i:s'),
                'end' => $appointment->appointment_date->format('Y-m-d') . 'T' . $appointment->appointment_time->copy()->addMinutes($appointment->duration ?? 30)->format('H:i:s'),
                'backgroundColor' => $this->getStatusColor($appointment->status),
                'borderColor' => $this->getStatusColor($appointment->status),
                'textColor' => '#fff',
                'extendedProps' => [
                    'patient' => $patientName,
                    'doctor' => $doctorName,
                    'treatment' => $appointment->treatment->name ?? '-',
                    'disease' => $appointment->disease ?? '-',
                    'status' => $appointment->status_text,
                    'notes' => $appointment->notes,
                    'time' => $appointment->appointment_time ? $appointment->appointment_time->format('H:i') : '',
                ],
            ];
        }

        return $events;
    }

    private function getStatusColor(string $status): string
    {
        return match ($status) {
            'scheduled' => '#ffc107',
            'completed' => '#28a745',
            default => '#6c757d',
        };
    }
}
