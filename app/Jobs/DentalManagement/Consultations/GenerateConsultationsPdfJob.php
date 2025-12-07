<?php

namespace App\Jobs\DentalManagement\Consultations;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateConsultationsPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $userId,
        public array $filters = []
    ) {}

    public function handle(): void
    {
        // Placeholder for PDF export functionality
        // This would typically use a package like DomPDF or TCPDF

        $consultations = Consultation::query()
            ->with(['patient', 'treatment', 'doctor'])
            ->filter($this->filters)
            ->notDeleted()
            ->orderBy('consultation_date', 'desc')
            ->get();

        $html = "<h1>Reporte de Consultas Médicas</h1>";
        $html .= "<table border='1' style='width: 100%; border-collapse: collapse;'>";
        $html .= "<tr><th>Paciente</th><th>Tipo Consulta</th><th>Doctor</th><th>Fecha</th><th>Costo</th></tr>";

        foreach ($consultations as $consultation) {
            $html .= sprintf(
                "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>S/ %s</td></tr>",
                $consultation->patient->name . ' ' . $consultation->patient->last_name,
                $consultation->treatment->name,
                $consultation->doctor->name,
                $consultation->consultation_date->format('d/m/Y'),
                number_format($consultation->cost, 2)
            );
        }

        $html .= "</table>";

        $filename = 'consultations_' . now()->format('Y-m-d_H-i-s') . '.html';
        Storage::disk('local')->put('user_downloads/' . $this->userId . '/' . $filename, $html);
    }
}