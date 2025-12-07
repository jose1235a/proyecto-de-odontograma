<?php

namespace App\Exports\DentalManagement\Doctors;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DoctorsExport implements FromCollection, WithHeadings, WithStyles
{
    protected Collection $doctors;

    public function __construct(Collection $doctors)
    {
        $this->doctors = $doctors;
    }

    public function collection(): Collection
    {
        return $this->doctors->values()->map(function ($doctor, $index) {
            return [
                $index + 1,
                $doctor->name,
                $doctor->last_name,
                strtoupper($doctor->document_type ?? ''),
                $doctor->document,
                $doctor->specialty->name ?? '-',
                $doctor->email,
                $doctor->phone ?? '-',
                $doctor->state_text,
                $doctor->created_at?->format('Y-m-d H:i:s'),
                $doctor->creator->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('dental_management.doctors.id'),
            __('dental_management.doctors.name'),
            __('dental_management.doctors.last_name'),
            __('dental_management.doctors.document_type'),
            __('dental_management.doctors.document'),
            __('dental_management.doctors.specialty'),
            __('dental_management.doctors.email'),
            __('dental_management.doctors.phone'),
            __('dental_management.doctors.is_active'),
            __('global.created_at'),
            __('global.created_by'),
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
