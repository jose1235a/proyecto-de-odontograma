<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Using Bootstrap Paginate
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

// Models and Observers
use App\Models\SystemModule;
use App\Observers\SystemModuleObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Call Boostrap on paginate
        Paginator::useBootstrap();

        // Register Observers
        SystemModule::observe(SystemModuleObserver::class);

        // Register Route Model Bindings for Dental Management
        Route::bind('patient', function ($value) {
            return \App\Models\Patient::where('slug', $value)->firstOrFail();
        });

        Route::bind('specialty', function ($value) {
            return \App\Models\Specialty::where('slug', $value)->firstOrFail();
        });

        Route::bind('doctor', function ($value) {
            return \App\Models\Doctor::where('slug', $value)->firstOrFail();
        });

        Route::bind('treatment', function ($value) {
            return \App\Models\Treatment::where('slug', $value)->firstOrFail();
        });

        Route::bind('appointment', function ($value) {
            return \App\Models\Appointment::where('slug', $value)->firstOrFail();
        });

        Route::bind('odontogram', function ($value) {
            return \App\Models\Odontogram::where('slug', $value)->firstOrFail();
        });

        Route::bind('appointment_history', function ($value) {
            return \App\Models\AppointmentHistory::where('slug', $value)->firstOrFail();
        });

        Route::bind('payment', function ($value) {
            return \App\Models\Payment::where('slug', $value)->firstOrFail();
        });

        // Share tenant_name in all views
        View::composer('*', function ($view) {
            $tenantName = null;

            if (Auth::check()) {
                // Load and rescue tenant relationship
                $user = Auth::user()->loadMissing('tenant');
                $tenantName = $user->tenant ? $user->tenant->name : null;
            }

            $view->with('tenant_name', $tenantName);
        });
    }

}
