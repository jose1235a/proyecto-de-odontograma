<?php

namespace App\Jobs\DentalManagement\Consultations;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateConsultationsWordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $userId,
        public array $filters = []
    ) {}

    public function handle(): void
    {
        // Placeholder for Word export functionality
        // This would typically use a package like PhpOffice/PhpWord

        $consultations = Consultation::query()
            ->with(['patient', 'treatment', 'doctor'])
            ->filter($this->filters)
            ->notDeleted()
            ->orderBy('consultation_date', 'desc')
            ->get();

        $content = "REPORTE DE CONSULTAS MÉDICAS\n\n";
        $content .= "Fecha de generación: " . now()->format('d/m/Y H:i:s') . "\n\n";

        foreach ($consultations as $consultation) {
            $content .= "PACIENTE: " . $consultation->patient->name . ' ' . $consultation->patient->last_name . "\n";
            $content .= "TIPO DE CONSULTA: " . $consultation->treatment->name . "\n";
            $content .= "DOCTOR: " . $consultation->doctor->name . "\n";
            $content .= "FECHA: " . $consultation->consultation_date->format('d/m/Y');
            if ($consultation->consultation_time) {
                $content .= " " . $consultation->consultation_time->format('H:i');
            }
            $content .= "\n";
            $content .= "COSTO: S/ " . number_format($consultation->cost, 2) . "\n";
            if ($consultation->fever) {
                $content .= "FIEBRE: " . $consultation->fever . "°C\n";
            }
            if ($consultation->blood_pressure) {
                $content .= "PRESIÓN ARTERIAL: " . $consultation->blood_pressure . "\n";
            }
            if ($consultation->description) {
                $content .= "DESCRIPCIÓN: " . $consultation->description . "\n";
            }
            $content .= "ESTADO: " . ($consultation->is_active ? 'Activo' : 'Inactivo') . "\n";
            $content .= str_repeat("-", 50) . "\n\n";
        }

        $filename = 'consultations_' . now()->format('Y-m-d_H-i-s') . '.txt';
        Storage::disk('local')->put('user_downloads/' . $this->userId . '/' . $filename, $content);
    }
}