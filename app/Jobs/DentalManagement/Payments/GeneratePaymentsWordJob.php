<?php

namespace App\Jobs\DentalManagement\Payments;

use App\Models\Download;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class GeneratePaymentsWordJob implements ShouldQueue
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

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Title
        $section->addTitle('Reporte de Pagos', 1);
        $section->addText('Generado el: ' . now()->format('d/m/Y H:i:s'));
        $section->addTextBreak(2);

        // Table
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(2000)->addText('Fecha de Pago');
        $table->addCell(3000)->addText('Paciente');
        $table->addCell(2000)->addText('Monto');
        $table->addCell(2000)->addText('Método');
        $table->addCell(2000)->addText('Estado');
        $table->addCell(3000)->addText('Referencia');

        foreach ($payments as $payment) {
            $table->addRow();
            $table->addCell(2000)->addText($payment->payment_date->format('d/m/Y'));
            $table->addCell(3000)->addText($payment->patient->name . ' ' . $payment->patient->last_name);
            $table->addCell(2000)->addText('S/ ' . number_format($payment->amount, 2));
            $table->addCell(2000)->addText($payment->payment_method_html ?? $payment->payment_method);
            $table->addCell(2000)->addText($payment->status_html ?? $payment->status);
            $table->addCell(3000)->addText($payment->reference_number ?? '-');
        }

        $filename = 'pagos_' . now()->format('Y-m-d_H-i-s') . '.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/' . $filename));

        Download::create([
            'user_id' => $this->userId,
            'filename' => $filename,
            'original_filename' => 'Pagos.docx',
            'path' => 'storage/' . $filename,
            'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'size' => \Storage::disk('public')->size($filename),
        ]);
    }
}