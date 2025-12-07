<?php

namespace App\Listeners;

use App\Events\OdontogramHistoryCreated;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;

class CompleteAppointmentOnOdontogramActivity
{
    public function handle(OdontogramHistoryCreated $event): void
    {
        $odontogramHistory = $event->odontogramHistory;
        $patientId = $odontogramHistory->odontogram->patient_id;

        // Buscar citas activas del paciente que estén en la ventana de tiempo
        // (desde la hora programada hasta 5 minutos después)
        $appointmentsCompleted = Appointment::where('patient_id', $patientId)
            ->where('status', 'scheduled')
            ->whereRaw("CONCAT(appointment_date, ' ', appointment_time) <= NOW()")
            ->whereRaw("DATE_ADD(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) >= NOW()")
            ->update(['status' => 'completed']);

        if ($appointmentsCompleted > 0) {
            \Log::info("Completed {$appointmentsCompleted} appointments for patient {$patientId} due to odontogram activity");
        }
    }
}