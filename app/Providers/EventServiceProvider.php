<?php

namespace App\Providers;

use App\Events\AppointmentCreated;
use App\Events\OdontogramHistoryCreated;
use App\Listeners\CancelOverdueAppointments;
use App\Listeners\CompleteAppointmentOnOdontogramActivity;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AppointmentCreated::class => [
            CancelOverdueAppointments::class,
        ],
        OdontogramHistoryCreated::class => [
            CompleteAppointmentOnOdontogramActivity::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}