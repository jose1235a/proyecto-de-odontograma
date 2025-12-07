<?php

namespace App\Exports\DentalManagement\Specialties;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SpecialtiesExport implements FromCollection, WithHeadings, WithStyles
{
    protected $specialties;

    public function __construct(Collection $specialties)
    {
        $this->specialties = $specialties;
    }

    public function collection()
    {
        return $this->specialties->values()->map(function ($specialty, $index) {
            return [
                $index + 1,
                $specialty->name,
                $specialty->description,
                $specialty->state_text,
                $specialty->created_at->format('Y-m-d H:i:s'),
                $specialty->creator->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('dental_management.specialties.id'),
            __('dental_management.specialties.name'),
            __('dental_management.specialties.description'),
            __('dental_management.specialties.is_active'),
            __('global.created_at'),
            __('global.created_by'),
        ];
    }

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
