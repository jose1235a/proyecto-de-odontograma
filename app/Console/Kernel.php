<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Aquí puedes registrar tus comandos personalizados
     */
    protected $commands = [
        // Ejemplo:
        // \App\Console\Commands\DropAndRecreateDatabase::class,
        \App\Console\Commands\DropAndRecreateDatabase::class,
    ];

    /**
     * Define las tareas programadas.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run daily at midnight
        $schedule->command('downloads:clean')->daily();

        // Process overdue appointments every minute
        $schedule->command('appointments:process-overdue')->everyMinute();

        // $schedule->command('inspire')->hourly();
    }
    /**
     * Registra los comandos y rutas de consola.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
 
}