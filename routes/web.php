<?php

// Use Illuminates
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

// Localization
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Controllers\AuthManagement\UserController;
 
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect','localizationRedirect','localeViewPath' ],
    ],
    function () {

        // Protected by auth
        Route::middleware(['auth'])->group(function () {

            // Main
            Route::get('/', function () {
                return Auth::check()
                    ? redirect()->route('dashboard_management.dashboards.index')
                    : redirect()->route('login');
            });

            require __DIR__.'/system_management.php';
            require __DIR__.'/dashboard_management.php';
            require __DIR__.'/download_management.php';
            require __DIR__.'/roles_permissions.php';
            require __DIR__.'/dental_management.php';

            // Auth Management
            Route::prefix('auth_management')->name('auth_management.')->group(function () {
                // Users
                Route::resource('users', UserController::class)->names('users');
                Route::get('users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
                Route::delete('users/{user}/deleteSave', [UserController::class, 'deleteSave'])->name('users.deleteSave');
            });
        });

        // Públic
        require __DIR__.'/auth_management.php';
        require __DIR__.'/legal_management.php';        
    }
);
