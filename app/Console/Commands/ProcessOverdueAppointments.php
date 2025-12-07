<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class ProcessOverdueAppointments extends Command
{
    protected $signature = 'appointments:process-overdue';
    protected $description = 'Process overdue appointments and update their status based on activity';

    public function handle()
    {
        $this->info('Processing overdue appointments...');

        // 1. Marcar como completadas las citas que están en la ventana de 5 minutos
        // y tienen actividad reciente en historial de odontogramas (acciones guardadas)
        $completed = Appointment::where('status', 'scheduled')
            ->whereRaw("CONCAT(appointment_date, ' ', appointment_time) <= NOW()")
            ->whereRaw("DATE_ADD(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) >= NOW()")
            ->whereHas('patient.odontograms.histories', function ($query) {
                $query->where('created_at', '>=', now()->subMinutes(10)); // Acciones guardadas en los últimos 10 minutos
            })
            ->update(['status' => 'completed']);

        $this->info("Completed {$completed} appointments with recent odontogram activity.");

        // 2. Marcar como canceladas las citas que pasaron más de 5 minutos
        // y no tienen actividad reciente en historial de odontogramas
        $cancelled = Appointment::where('status', 'scheduled')
            ->whereRaw("DATE_ADD(CONCAT(appointment_date, ' ', appointment_time), INTERVAL 5 MINUTE) <= NOW()")
            ->whereDoesntHave('patient.odontograms.histories', function ($query) {
                $query->where('created_at', '>=', now()->subMinutes(10)); // Sin acciones guardadas recientes
            })
            ->update(['status' => 'cancelled']);

        $this->info("Cancelled {$cancelled} appointments without recent activity.");

        $this->info('Processing completed.');
    }
}