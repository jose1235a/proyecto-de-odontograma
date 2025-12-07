<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManagement\RoleController;

Route::prefix('auth_management')->name('auth_management.')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/delete', [RoleController::class, 'delete'])->name('roles.delete');
});
