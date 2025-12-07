<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemManagement\SystemModuleController;
use App\Http\Controllers\SystemManagement\SettingController;
use App\Http\Controllers\SystemManagement\CountryController;
use App\Http\Controllers\SystemManagement\LanguageController;
use App\Http\Controllers\SystemManagement\TenantController;
use App\Http\Controllers\SystemManagement\RegionController;

Route::prefix('system_management')->name('system_management.')->group(function () {

    // ------------------------------
    // System Modules
    // ------------------------------
    Route::get('system_modules/export_excel', [SystemModuleController::class, 'exportExcel'])->name('system_modules.export_excel');
    Route::get('system_modules/export_pdf',   [SystemModuleController::class, 'exportPdf'])->name('system_modules.export_pdf');
    Route::get('system_modules/export_word',  [SystemModuleController::class, 'exportWord'])->name('system_modules.export_word');
    Route::get('system_modules/edit_all',     [SystemModuleController::class, 'editAll'])->name('system_modules.edit_all');
    Route::post('system_modules/update_inline', [SystemModuleController::class, 'updateInline'])->name('system_modules.update_inline');

    Route::resource('system_modules', SystemModuleController::class)->names('system_modules');
    Route::get('system_modules/{system_module}/delete',        [SystemModuleController::class, 'delete'])->name('system_modules.delete');
    Route::delete('system_modules/{system_module}/deleteSave', [SystemModuleController::class, 'deleteSave'])->name('system_modules.deleteSave');
    Route::post('system_modules/{system_module}/permissions',  [SystemModuleController::class, 'storePermission'])->name('system_modules.permissions.store');
    Route::delete('system_modules/{system_module}/permissions/{permission}', [SystemModuleController::class, 'destroyPermission'])->name('system_modules.permissions.destroy');

    // ------------------------------
    // Tenants
    // ------------------------------
    Route::get('tenants/export_excel', [TenantController::class, 'exportExcel'])->name('tenants.export_excel');
    Route::get('tenants/export_pdf',   [TenantController::class, 'exportPdf'])->name('tenants.export_pdf');
    Route::get('tenants/export_word',  [TenantController::class, 'exportWord'])->name('tenants.export_word');
    Route::get('tenants/edit_all',     [TenantController::class, 'editAll'])->name('tenants.edit_all');
    Route::post('tenants/update_inline', [TenantController::class, 'updateInline'])->name('tenants.update_inline');

    Route::resource('tenants', TenantController::class)->names('tenants');
    Route::get('tenants/{tenant}/delete',        [TenantController::class, 'delete'])->name('tenants.delete');
    Route::delete('tenants/{tenant}/deleteSave', [TenantController::class, 'deleteSave'])->name('tenants.deleteSave');

    // ------------------------------
    // Regions
    // ------------------------------
    Route::get('regions/export_excel', [RegionController::class, 'exportExcel'])->name('regions.export_excel');
    Route::get('regions/export_pdf',   [RegionController::class, 'exportPdf'])->name('regions.export_pdf');
    Route::get('regions/export_word',  [RegionController::class, 'exportWord'])->name('regions.export_word');
    Route::get('regions/edit_all',     [RegionController::class, 'editAll'])->name('regions.edit_all');
    Route::post('regions/update_inline', [RegionController::class, 'updateInline'])->name('regions.update_inline');

    Route::resource('regions', RegionController::class)->names('regions');
    Route::get('regions/{region}/delete',        [RegionController::class, 'delete'])->name('regions.delete');
    Route::delete('regions/{region}/deleteSave', [RegionController::class, 'deleteSave'])->name('regions.deleteSave');

    // ------------------------------
    // Languages
    // ------------------------------
    Route::get('languages/export_excel', [LanguageController::class, 'exportExcel'])->name('languages.export_excel');
    Route::get('languages/export_pdf',   [LanguageController::class, 'exportPdf'])->name('languages.export_pdf');
    Route::get('languages/export_word',  [LanguageController::class, 'exportWord'])->name('languages.export_word');
    Route::get('languages/edit_all',     [LanguageController::class, 'editAll'])->name('languages.edit_all');
    Route::post('languages/update_inline', [LanguageController::class, 'updateInline'])->name('languages.update_inline');

    Route::resource('languages', LanguageController::class)->names('languages');
    Route::get('languages/{language}/delete',        [LanguageController::class, 'delete'])->name('languages.delete');
    Route::delete('languages/{language}/deleteSave', [LanguageController::class, 'deleteSave'])->name('languages.deleteSave');

    // ------------------------------
    // Settings
    // ------------------------------
    // Route::resource('settings', SettingController::class)->names('settings');
    // Route::get('settings/{setting}/delete', [SettingController::class, 'delete'])->name('settings.delete');
    // Route::delete('settings/{setting}/deleteSave', [SettingController::class, 'deleteSave'])->name('settings.deleteSave');
    // Route::get('settings/live_edit', [SettingController::class, 'liveEdit'])->name('settings.live_edit');
    // Route::post('settings/update_inline', [SettingController::class, 'updateInline'])->name('settings.update_inline');
    // Route::get('settings/export_excel', [SettingController::class, 'exportExcel'])->name('settings.export_excel');
    // Route::get('settings/export_pdf',   [SettingController::class, 'exportPdf'])->name('settings.export_pdf');

    // ------------------------------
    // Countries
    // ------------------------------
    // Route::resource('countries', CountryController::class)->names('countries');
    // Route::get('countries/{country}/delete', [CountryController::class, 'delete'])->name('countries.delete');
    // Route::delete('countries/{country}/deleteSave', [CountryController::class, 'deleteSave'])->name('countries.deleteSave');
    // Route::get('countries/live_edit', [CountryController::class, 'liveEdit'])->name('countries.live_edit');
    // Route::post('countries/update_inline', [CountryController::class, 'updateInline'])->name('countries.update_inline');
    // Route::get('countries/export_excel', [CountryController::class, 'exportExcel'])->name('countries.export_excel');
    // Route::get('countries/export_pdf',   [CountryController::class, 'exportPdf'])->name('countries.export_pdf');
});