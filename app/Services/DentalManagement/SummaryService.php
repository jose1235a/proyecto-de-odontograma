<?php

namespace App\Services\DentalManagement;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Doctor;
use App\Models\Treatment;
use Illuminate\Support\Facades\DB;

class SummaryService
{
    public function getCompleteSummary(): array
    {
        return [
            // General Statistics
            'general' => $this->getGeneralStats(),

            // Monthly Trends (Last 12 months)
            'monthly_trends' => $this->getMonthlyTrends(),

            // Top Performers
            'top_doctors' => $this->getTopDoctors(),
            'top_treatments' => $this->getTopTreatments(),

            // Financial Summary
            'financial' => $this->getFinancialSummary(),

            // Recent Activity
            'recent_appointments' => $this->getRecentAppointments(),
            'recent_payments' => $this->getRecentPayments(),

            // System Health
            'system_health' => $this->getSystemHealth(),
        ];
    }

    private function getGeneralStats(): array
    {
        return [
            'total_patients' => Patient::notDeleted()->count(),
            'active_patients' => Patient::notDeleted()->where('is_active', true)->count(),
            'total_doctors' => Doctor::notDeleted()->count(),
            'active_doctors' => Doctor::notDeleted()->where('is_active', true)->count(),
            'total_treatments' => Treatment::notDeleted()->count(),
            'total_appointments' => Appointment::notDeleted()->count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
        ];
    }

    private function getMonthlyTrends(): array
    {
        $trends = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M Y');

            $trends[$monthName] = [
                'appointments' => Appointment::whereYear('appointment_date', $date->year)
                    ->whereMonth('appointment_date', $date->month)
                    ->count(),
                'payments' => Payment::whereYear('payment_date', $date->year)
                    ->whereMonth('payment_date', $date->month)
                    ->where('status', 'completed')
                    ->sum('amount'),
                'new_patients' => Patient::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }

        return $trends;
    }

    private function getTopDoctors(): array
    {
        return Appointment::select('doctor_id', DB::raw('count(*) as total_appointments'))
            ->with('doctor')
            ->whereNotNull('doctor_id')
            ->groupBy('doctor_id')
            ->orderBy('total_appointments', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'doctor' => $item->doctor->name ?? 'Unknown',
                    'appointments' => $item->total_appointments,
                ];
            })
            ->toArray();
    }

    private function getTopTreatments(): array
    {
        return Appointment::select('treatment_id', DB::raw('count(*) as total_appointments'))
            ->with('treatment')
            ->whereNotNull('treatment_id')
            ->groupBy('treatment_id')
            ->orderBy('total_appointments', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'treatment' => $item->treatment->name ?? 'Unknown',
                    'appointments' => $item->total_appointments,
                ];
            })
            ->toArray();
    }

    private function getFinancialSummary(): array
    {
        return [
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->sum('amount'),
            'monthly_revenue' => Payment::where('status', 'completed')
                ->whereYear('payment_date', now()->year)
                ->whereMonth('payment_date', now()->month)
                ->sum('amount'),
            'average_payment' => Payment::where('status', 'completed')->avg('amount') ?? 0,
        ];
    }

    private function getRecentAppointments(): array
    {
        return Appointment::with(['patient', 'doctor', 'treatment'])
            ->notDeleted()
            ->orderBy('appointment_date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'patient' => $appointment->patient->name ?? 'Unknown',
                    'doctor' => $appointment->doctor->name ?? 'Unknown',
                    'treatment' => $appointment->treatment->name ?? 'Unknown',
                    'date' => $appointment->appointment_date->format('d/m/Y H:i'),
                    'status' => $appointment->status,
                ];
            })
            ->toArray();
    }

    private function getRecentPayments(): array
    {
        return Payment::with(['patient'])
            ->notDeleted()
            ->orderBy('payment_date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'patient' => $payment->patient->name ?? 'Unknown',
                    'amount' => $payment->amount,
                    'method' => $payment->payment_method,
                    'date' => $payment->payment_date->format('d/m/Y'),
                    'status' => $payment->status,
                ];
            })
            ->toArray();
    }

    private function getSystemHealth(): array
    {
        return [
            'database_connections' => DB::getConnections(),
            'cache_status' => cache()->store()->getStore() ? 'OK' : 'Error',
            'storage_writable' => is_writable(storage_path()) ? 'OK' : 'Error',
            'last_backup' => 'Not configured', // Could be enhanced with backup system
        ];
    }
}