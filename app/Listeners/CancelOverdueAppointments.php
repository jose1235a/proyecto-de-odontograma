<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use App\Models\Appointment;

class CancelOverdueAppointments
{
    public function handle(AppointmentCreated $event): void
    {
        // 1. Marcar como completadas las citas que están en la ventana de 5 minutos
        // y tienen actividad reciente en historial de odontogramas (acciones guardadas)
        Appointment::where('status', 'scheduled')
            ->whereRaw("CONCAT(appointment_date, ' ', appointment_time) <= NOW()")
            ->whereRaw("DATE_ADD(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) >= NOW()")
            ->whereHas('patient.odontograms.histories', function ($query) {
                $query->where('created_at', '>=', now()->subMinutes(10)); // Acciones guardadas en los últimos 10 minutos
            })
            ->update(['status' => 'completed']);

        // 2. Marcar como canceladas las citas que pasaron más de 5 minutos
        // y no tienen actividad reciente en historial de odontogramas
        Appointment::where('status', 'scheduled')
            ->whereRaw("DATE_ADD(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) <= NOW()")
            ->whereDoesntHave('patient.odontograms.histories', function ($query) {
                $query->where('created_at', '>=', now()->subMinutes(10)); // Sin acciones guardadas recientes
            })
            ->update(['status' => 'cancelled']);
    }
}