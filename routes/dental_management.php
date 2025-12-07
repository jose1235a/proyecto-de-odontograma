<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DentalManagement\PatientController;
use App\Http\Controllers\DentalManagement\PatientImageController;
use App\Http\Controllers\DentalManagement\SpecialtyController;
use App\Http\Controllers\DentalManagement\DoctorController;
use App\Http\Controllers\DentalManagement\TreatmentController;
use App\Http\Controllers\DentalManagement\AppointmentController;
use App\Http\Controllers\DentalManagement\OdontogramController;
use App\Http\Controllers\DentalManagement\OdontogramHistoryController;
use App\Http\Controllers\DentalManagement\TreatmentHistoryController;
use App\Http\Controllers\DentalManagement\AppointmentHistoryController;
use App\Http\Controllers\DentalManagement\CalendarController;
use App\Http\Controllers\DentalManagement\PaymentController;
use App\Http\Controllers\DentalManagement\ReportsController as ReportController;
use App\Http\Controllers\DentalManagement\SummaryController;
use App\Http\Controllers\DentalManagement\ConsultationController;

Route::prefix('dental_management')->name('dental_management.')->group(function () {

    // Patients
    Route::get('patients/export_excel', [PatientController::class, 'exportExcel'])->name('patients.export_excel');
    Route::get('patients/export_pdf',   [PatientController::class, 'exportPdf'])->name('patients.export_pdf');
    Route::get('patients/export_word',  [PatientController::class, 'exportWord'])->name('patients.export_word');
    Route::get('patients/edit_all',     [PatientController::class, 'editAll'])->name('patients.edit_all');
    Route::post('patients/update_inline', [PatientController::class, 'updateInline'])->name('patients.update_inline');
    Route::post('patients/dni-lookup', [PatientController::class, 'dniLookup'])->name('patients.dni.lookup');
    Route::post('patients/{patient}/upload-image', [PatientController::class, 'uploadImage'])->name('patients.upload_image');
    Route::delete('patients/{patient}/delete-image', [PatientController::class, 'deleteImage'])->name('patients.delete_image');

    Route::resource('patients', PatientController::class)->names('patients');
    Route::get('patients/{patient}/delete', [PatientController::class, 'delete'])->name('patients.delete');
    Route::delete('patients/{patient}/deleteSave', [PatientController::class, 'deleteSave'])->name('patients.deleteSave');

    // Patient Images
    Route::get('patient_images/export_excel', [PatientImageController::class, 'exportExcel'])->name('patient_images.export_excel');
    Route::get('patient_images/export_pdf',   [PatientImageController::class, 'exportPdf'])->name('patient_images.export_pdf');
    Route::get('patient_images/export_word',  [PatientImageController::class, 'exportWord'])->name('patient_images.export_word');
    Route::get('patient_images/edit_all',     [PatientImageController::class, 'editAll'])->name('patient_images.edit_all');

    Route::resource('patient_images', PatientImageController::class)->names('patient_images');
    Route::get('patient_images/{patient_image}/delete', [PatientImageController::class, 'delete'])->name('patient_images.delete');
    Route::delete('patient_images/{patient_image}/deleteSave', [PatientImageController::class, 'deleteSave'])->name('patient_images.deleteSave');

    // Specialties
    Route::get('specialties/export_excel', [SpecialtyController::class, 'exportExcel'])->name('specialties.export_excel');
    Route::get('specialties/export_pdf',   [SpecialtyController::class, 'exportPdf'])->name('specialties.export_pdf');
    Route::get('specialties/export_word',  [SpecialtyController::class, 'exportWord'])->name('specialties.export_word');
    Route::get('specialties/edit_all',     [SpecialtyController::class, 'editAll'])->name('specialties.edit_all');
    Route::post('specialties/update_inline', [SpecialtyController::class, 'updateInline'])->name('specialties.update_inline');

    Route::resource('specialties', SpecialtyController::class)->names('specialties');
    Route::get('specialties/{specialty}/delete', [SpecialtyController::class, 'delete'])->name('specialties.delete');
    Route::delete('specialties/{specialty}/deleteSave', [SpecialtyController::class, 'deleteSave'])->name('specialties.deleteSave');

    // Doctors
    Route::get('doctors/export_excel', [DoctorController::class, 'exportExcel'])->name('doctors.export_excel');
    Route::get('doctors/export_pdf',   [DoctorController::class, 'exportPdf'])->name('doctors.export_pdf');
    Route::get('doctors/export_word',  [DoctorController::class, 'exportWord'])->name('doctors.export_word');
    Route::get('doctors/edit_all',     [DoctorController::class, 'editAll'])->name('doctors.edit_all');
    Route::post('doctors/update_inline', [DoctorController::class, 'updateInline'])->name('doctors.update_inline');
    Route::post('doctors/dni-lookup', [DoctorController::class, 'dniLookup'])->name('doctors.dni.lookup');

    Route::resource('doctors', DoctorController::class)->names('doctors');
    Route::get('doctors/{doctor}/delete', [DoctorController::class, 'delete'])->name('doctors.delete');
    Route::delete('doctors/{doctor}/deleteSave', [DoctorController::class, 'deleteSave'])->name('doctors.deleteSave');

    // Treatments
    Route::get('treatments/export_excel', [TreatmentController::class, 'exportExcel'])->name('treatments.export_excel');
    Route::get('treatments/export_pdf',   [TreatmentController::class, 'exportPdf'])->name('treatments.export_pdf');
    Route::get('treatments/export_word',  [TreatmentController::class, 'exportWord'])->name('treatments.export_word');
    Route::get('treatments/edit_all',     [TreatmentController::class, 'editAll'])->name('treatments.edit_all');
    Route::post('treatments/update_inline', [TreatmentController::class, 'updateInline'])->name('treatments.update_inline');
    // AJAX endpoints consumed by the odontogram editor bundles
    Route::post('treatments/update-colors', [TreatmentController::class, 'updateColors'])->name('treatments.update_colors');

    Route::resource('treatments', TreatmentController::class)->names('treatments');
    Route::get('treatments/{treatment}/delete', [TreatmentController::class, 'delete'])->name('treatments.delete');
    Route::delete('treatments/{treatment}/deleteSave', [TreatmentController::class, 'deleteSave'])->name('treatments.deleteSave');

    // Appointments
    Route::get('appointments/search_patient', [AppointmentController::class, 'searchPatient'])->name('appointments.search_patient');
    Route::get('appointments/export_excel', [AppointmentController::class, 'exportExcel'])->name('appointments.export_excel');
    Route::get('appointments/export_pdf', [AppointmentController::class, 'exportPdf'])->name('appointments.export_pdf');
    Route::get('appointments/export_word', [AppointmentController::class, 'exportWord'])->name('appointments.export_word');
    Route::get('appointments/edit_all', [AppointmentController::class, 'editAll'])->name('appointments.edit_all');
    Route::post('appointments/update_inline', [AppointmentController::class, 'updateInline'])->name('appointments.update_inline');

    Route::resource('appointments', AppointmentController::class)->names('appointments');
    Route::get('appointments/{appointment}/delete', [AppointmentController::class, 'delete'])->name('appointments.delete');
    Route::delete('appointments/{appointment}/deleteSave', [AppointmentController::class, 'deleteSave'])->name('appointments.deleteSave');

    // Consultations
    Route::get('consultations/export_excel', [ConsultationController::class, 'exportExcel'])->name('consultations.export_excel');
    Route::get('consultations/export_pdf',   [ConsultationController::class, 'exportPdf'])->name('consultations.export_pdf');
    Route::get('consultations/export_word',  [ConsultationController::class, 'exportWord'])->name('consultations.export_word');
    Route::get('consultations/edit_all',     [ConsultationController::class, 'editAll'])->name('consultations.edit_all');
    Route::post('consultations/update_inline', [ConsultationController::class, 'updateInline'])->name('consultations.update_inline');

    Route::resource('consultations', ConsultationController::class)->names('consultations');
    Route::get('consultations/{consultation}/delete', [ConsultationController::class, 'delete'])->name('consultations.delete');
    Route::delete('consultations/{consultation}/deleteSave', [ConsultationController::class, 'deleteSave'])->name('consultations.deleteSave');

    // Odontogram
    Route::resource('odontogram', OdontogramController::class)->names('odontogram');
    Route::get('odontogram/{odontogram}/delete', [OdontogramController::class, 'delete'])->name('odontogram.delete');
    Route::delete('odontogram/{odontogram}/deleteSave', [OdontogramController::class, 'deleteSave'])->name('odontogram.deleteSave');
    Route::put('odontogram_histories/{odontogram_history}', [OdontogramHistoryController::class, 'update'])->name('odontogram_histories.update');
    Route::delete('odontogram_histories/{odontogram_history}', [OdontogramHistoryController::class, 'destroy'])->name('odontogram_histories.destroy');

    // Treatment History (consumed por el visor del odontograma)
    Route::get('treatment-history', [TreatmentHistoryController::class, 'index'])->name('treatment_history.index');

    // Appointment History
    Route::resource('appointment_history', AppointmentHistoryController::class)->names('appointment_history');
    Route::get('appointment_history/{appointment_history}/delete', [AppointmentHistoryController::class, 'delete'])->name('appointment_history.delete');
    Route::delete('appointment_history/{appointment_history}/deleteSave', [AppointmentHistoryController::class, 'deleteSave'])->name('appointment_history.deleteSave');

    // Calendar
    Route::get('calendar/events', [CalendarController::class, 'events'])->name('calendar.events');
    Route::resource('calendar', CalendarController::class)->names('calendar');
    Route::get('calendar/{calendar}/delete', [CalendarController::class, 'delete'])->name('calendar.delete');
    Route::delete('calendar/{calendar}/deleteSave', [CalendarController::class, 'deleteSave'])->name('calendar.deleteSave');

    // Payments
    Route::get('payments/search_patient', [PaymentController::class, 'searchPatient'])->name('payments.search_patient');
    Route::get('payments/search_patient_appointments', [PaymentController::class, 'searchPatientAppointments'])->name('payments.search_patient_appointments');
    Route::get('payments/export_excel', [PaymentController::class, 'exportExcel'])->name('payments.export_excel');
    Route::get('payments/export_pdf',   [PaymentController::class, 'exportPdf'])->name('payments.export_pdf');
    Route::get('payments/export_word',  [PaymentController::class, 'exportWord'])->name('payments.export_word');
    Route::get('payments/edit_all',     [PaymentController::class, 'editAll'])->name('payments.edit_all');
    Route::post('payments/update_inline', [PaymentController::class, 'updateInline'])->name('payments.update_inline');

    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/{slug}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('payments/{slug}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('payments/{slug}', [PaymentController::class, 'update'])->name('payments.update');
    Route::get('payments/{slug}/delete', [PaymentController::class, 'delete'])->name('payments.delete');
    Route::delete('payments/{slug}/deleteSave', [PaymentController::class, 'deleteSave'])->name('payments.deleteSave');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/appointments', [ReportController::class, 'appointments'])->name('reports.appointments');
    Route::get('reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
    Route::get('reports/patients', [ReportController::class, 'patients'])->name('reports.patients');
    Route::get('reports/export_appointments', [ReportController::class, 'exportAppointments'])->name('reports.export_appointments');
    Route::get('reports/export_payments', [ReportController::class, 'exportPayments'])->name('reports.export_payments');
    Route::get('reports/export_patients', [ReportController::class, 'exportPatients'])->name('reports.export_patients');

    // Summary
    Route::resource('summary', SummaryController::class)->names('summary');
    Route::get('summary/{summary}/delete', [SummaryController::class, 'delete'])->name('summary.delete');
    Route::delete('summary/{summary}/deleteSave', [SummaryController::class, 'deleteSave'])->name('summary.deleteSave');
});
