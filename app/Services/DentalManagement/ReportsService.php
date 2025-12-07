<?php

namespace App\Services\DentalManagement;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsService
{
    public function getDashboardStats(): array
    {
        return [
            'total_patients' => Patient::notDeleted()->count(),
            'total_appointments' => Appointment::notDeleted()->count(),
            'total_payments' => Payment::notDeleted()->sum('amount'),
            'appointments_today' => Appointment::whereDate('appointment_date', today())->count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
        ];
    }

    public function getAppointmentsReport(Request $request): array
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());
        $status = $request->get('status');

        $query = Appointment::with(['patient', 'doctor', 'treatment'])
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->notDeleted();

        if ($status) {
            $query->where('status', $status);
        }

        $appointments = $query->get();

        $stats = [
            'total' => $appointments->count(),
            'scheduled' => $appointments->where('status', 'scheduled')->count(),
            'confirmed' => $appointments->where('status', 'confirmed')->count(),
            'completed' => $appointments->where('status', 'completed')->count(),
            'cancelled' => $appointments->where('status', 'cancelled')->count(),
        ];

        return compact('appointments', 'stats', 'startDate', 'endDate');
    }

    public function getPaymentsReport(Request $request): array
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());
        $method = $request->get('payment_method');

        $query = Payment::with(['patient', 'appointment'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->notDeleted();

        if ($method) {
            $query->where('payment_method', $method);
        }

        $payments = $query->get();

        $stats = [
            'total_amount' => $payments->sum('amount'),
            'total_payments' => $payments->count(),
            'completed' => $payments->where('status', 'completed')->sum('amount'),
            'pending' => $payments->where('status', 'pending')->sum('amount'),
            'by_method' => $payments->groupBy('payment_method')->map(function ($group) {
                return $group->sum('amount');
            }),
        ];

        return compact('payments', 'stats', 'startDate', 'endDate');
    }

    public function getPatientsReport(Request $request): array
    {
        $patients = Patient::with(['appointments', 'payments'])
            ->withCount(['appointments', 'payments'])
            ->notDeleted()
            ->get();

        $stats = [
            'total_patients' => $patients->count(),
            'active_patients' => $patients->where('is_active', true)->count(),
            'inactive_patients' => $patients->where('is_active', false)->count(),
            'patients_with_appointments' => $patients->where('appointments_count', '>', 0)->count(),
            'patients_with_payments' => $patients->where('payments_count', '>', 0)->count(),
        ];

        return compact('patients', 'stats');
    }

    public function exportAppointments(Request $request)
    {
        // Implementation for Excel export
        // This would use Maatwebsite Excel package
        return response()->json(['message' => 'Export functionality to be implemented']);
    }

    public function exportPayments(Request $request)
    {
        // Implementation for Excel export
        return response()->json(['message' => 'Export functionality to be implemented']);
    }

    public function exportPatients(Request $request)
    {
        // Implementation for Excel export
        return response()->json(['message' => 'Export functionality to be implemented']);
    }
}