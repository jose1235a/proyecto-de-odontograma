<?php

namespace App\Exports\DentalManagement\Appointments;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AppointmentsExport implements FromCollection, WithHeadings, WithStyles
{
    protected Collection $appointments;

    public function __construct(Collection $appointments)
    {
        $this->appointments = $appointments;
    }

    public function collection(): Collection
    {
        return $this->appointments->values()->map(function ($appointment, $index) {
            $doctorName = $appointment->doctor ? trim($appointment->doctor->name . ' ' . ($appointment->doctor->last_name ?? '')) : '-';
            $patientName = $appointment->patient ? trim($appointment->patient->name . ' ' . ($appointment->patient->last_name ?? '')) : '-';

            return [
                $index + 1,
                $appointment->treatment->name ?? '-',
                $doctorName,
                $patientName,
                $appointment->appointment_date ? $appointment->appointment_date->format('d/m/Y') : '-',
                $appointment->appointment_time ? $appointment->appointment_time->format('H:i') : '-',
                $appointment->disease ?? '-',
                $appointment->status_text,
                $appointment->cost ?? 0,
                $appointment->paid ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('global.id'),
            __('dental_management.appointments.treatment'),
            __('dental_management.appointments.doctor'),
            __('dental_management.appointments.patient'),
            __('dental_management.appointments.date'),
            __('dental_management.appointments.time'),
            __('dental_management.appointments.disease'),
            __('dental_management.appointments.status'),
            __('dental_management.appointments.cost'),
            __('dental_management.appointments.paid'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => 'solid',
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
    }
}
