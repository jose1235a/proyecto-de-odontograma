<?php

namespace App\Jobs\DentalManagement\Payments;

use App\Models\Download;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class GeneratePaymentsPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $userId,
        public array $filters = []
    ) {}

    public function handle(): void
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

        $payments = $query->notDeleted()->orderBy('payment_date', 'desc')->get();

        $pdf = Pdf::loadView('dental_management.payments.exports.pdf', compact('payments'));

        $filename = 'pagos_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        $pdf->save(storage_path('app/public/' . $filename));

        Download::create([
            'user_id' => $this->userId,
            'filename' => $filename,
            'original_filename' => 'Pagos.pdf',
            'path' => 'storage/' . $filename,
            'mime_type' => 'application/pdf',
            'size' => \Storage::disk('public')->size($filename),
        ]);
    }
}