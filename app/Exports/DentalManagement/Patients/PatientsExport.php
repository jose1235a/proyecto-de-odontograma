<?php

// Namspace
namespace App\Exports\DentalManagement\Patients;

// Excel Library
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Main class
class PatientsExport implements FromCollection, WithHeadings, WithStyles
{
    // Table
    protected $patients;

    // Array
    public function __construct(Collection $patients)
    {
        $this->patients = $patients;
    }

    // Rows
    public function collection()
    {
        return $this->patients->values()->map(function ($patient, $index) {
            return [
                $index + 1,
                $patient->name,
                $patient->last_name,
                $patient->email,
                $patient->phone,
                $patient->document,
                $patient->state_text,
                $patient->created_at->format('Y-m-d H:i:s'),
                $patient->creator->name ?? '-',
            ];
        });
    }

    // Columns
    public function headings(): array
    {
        return [
            __('dental_management.patients.id'),
            __('dental_management.patients.name'),
            __('dental_management.patients.last_name'),
            __('dental_management.patients.email'),
            __('dental_management.patients.phone'),
            __('dental_management.patients.document'),
            __('dental_management.patients.is_active'),
            __('global.created_at'),
            __('global.created_by'),
        ];
    }

    // Styles
    public function styles(Worksheet $sheet)
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