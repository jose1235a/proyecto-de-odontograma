<?php

namespace App\Jobs\DentalManagement\Payments;

use App\Exports\DentalManagement\Payments\PaymentsExport;
use App\Models\Download;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class GeneratePaymentsExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $userId,
        public array $filters = []
    ) {}

    public function handle(): void
    {
        $filename = 'pagos_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        Excel::store(
            new PaymentsExport($this->filters),
            $filename,
            'public',
            \Maatwebsite\Excel\Excel::XLSX
        );

        Download::create([
            'user_id' => $this->userId,
            'filename' => $filename,
            'original_filename' => 'Pagos.xlsx',
            'path' => 'storage/' . $filename,
            'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'size' => \Storage::disk('public')->size($filename),
        ]);
    }
}