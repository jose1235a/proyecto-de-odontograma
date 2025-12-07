<?php

namespace App\Exports\DentalManagement\Treatments;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TreatmentsExport implements FromCollection, WithHeadings, WithStyles
{
    protected Collection $treatments;

    public function __construct(Collection $treatments)
    {
        $this->treatments = $treatments;
    }

    public function collection(): Collection
    {
        return $this->treatments->values()->map(function ($treatment, $index) {
            return [
                $index + 1,
                $treatment->name,
                number_format($treatment->cost, 2, '.', ''),
                $treatment->state_text,
                formatDateTime($treatment->created_at),
                $treatment->creator->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('global.id'),
            __('dental_management.treatments.name'),
            __('dental_management.treatments.cost'),
            __('dental_management.treatments.is_active'),
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
