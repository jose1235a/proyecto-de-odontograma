<?php

namespace App\Jobs\DentalManagement\Consultations;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateConsultationsExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $userId,
        public array $filters = []
    ) {}

    public function handle(): void
    {
        // Placeholder for Excel export functionality
        // This would typically use a package like Laravel Excel (maatwebsite/excel)
        // For now, just create a simple CSV file

        $consultations = Consultation::query()
            ->with(['patient', 'treatment', 'doctor'])
            ->filter($this->filters)
            ->notDeleted()
            ->orderBy('consultation_date', 'desc')
            ->get();

        $csvContent = "Paciente,Tipo Consulta,Doctor,Fecha,Hora,Costo,Fiebre,Presion Arterial,Estado\n";

        foreach ($consultations as $consultation) {
            $csvContent .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                $consultation->patient->name . ' ' . $consultation->patient->last_name,
                $consultation->treatment->name,
                $consultation->doctor->name,
                $consultation->consultation_date->format('d/m/Y'),
                $consultation->consultation_time ? $consultation->consultation_time->format('H:i') : '',
                $consultation->cost,
                $consultation->fever ?: '',
                $consultation->blood_pressure ?: '',
                $consultation->is_active ? 'Activo' : 'Inactivo'
            );
        }

        $filename = 'consultations_' . now()->format('Y-m-d_H-i-s') . '.csv';
        Storage::disk('local')->put('user_downloads/' . $this->userId . '/' . $filename, $csvContent);
    }
}