<?php

namespace App\Exports\DentalManagement\Payments;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaymentsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        public array $filters = []
    ) {}

    public function query()
    {
        $query = Payment::query()->with(['patient', 'appointment.treatment', 'appointment.doctor']);

        // Apply filters
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['payment_method'])) {
            $query->where('payment_method', $this->filters['payment_method']);
        }

        if (!empty($this->filters['start_date'])) {
            $query->whereDate('payment_date', '>=', $this->filters['start_date']);
        }

        if (!empty($this->filters['end_date'])) {
            $query->whereDate('payment_date', '<=', $this->filters['end_date']);
        }

        if (!empty($this->filters['patient_id'])) {
            $query->where('patient_id', $this->filters['patient_id']);
        }

        return $query->notDeleted()->orderBy('payment_date', 'desc');
    }

    public function headings(): array
    {
        return [
            'Fecha de Pago',
            'Paciente',
            'DNI',
            'Monto',
            'Método de Pago',
            'Estado',
            'Número de Referencia',
            'Notas',
            'Tratamiento',
            'Doctor',
            'Fecha de Creación'
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->payment_date->format('d/m/Y'),
            $payment->patient->name . ' ' . $payment->patient->last_name,
            $payment->patient->document,
            $payment->amount,
            $payment->payment_method,
            $payment->status,
            $payment->reference_number ?? '',
            $payment->notes ?? '',
            $payment->appointment->treatment->name ?? '',
            $payment->appointment->doctor->name . ' ' . ($payment->appointment->doctor->last_name ?? '') ?? '',
            $payment->created_at->format('d/m/Y H:i:s')
        ];
    }
}