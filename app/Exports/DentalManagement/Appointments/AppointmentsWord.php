<?php

namespace App\Exports\DentalManagement\Appointments;

use PhpOffice\PhpWord\TemplateProcessor;

class AppointmentsWord
{
    public function generate($appointments, string $filename): void
    {
        $template = new TemplateProcessor(
            resource_path('templates/dental_management/appointments/template.docx')
        );

        $template->setValue('title', __('dental_management.appointments.plural'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        $template->setValue('header_no', __('global.no'));
        $template->setValue('header_treatment', __('dental_management.appointments.treatment'));
        $template->setValue('header_doctor', __('dental_management.appointments.doctor'));
        $template->setValue('header_patient', __('dental_management.appointments.patient'));
        $template->setValue('header_date', __('dental_management.appointments.date'));
        $template->setValue('header_time', __('dental_management.appointments.time'));
        $template->setValue('header_status', __('dental_management.appointments.status'));
        $template->setValue('header_cost', __('dental_management.appointments.cost'));
        $template->setValue('header_paid', __('dental_management.appointments.paid'));

        $count = max($appointments->count(), 1);
        $template->cloneRow('no', $count);

        if ($appointments->isEmpty()) {
            $template->setValue('no#1', '1');
            $template->setValue('treatment#1', '-');
            $template->setValue('doctor#1', '-');
            $template->setValue('patient#1', '-');
            $template->setValue('date#1', '-');
            $template->setValue('time#1', '-');
            $template->setValue('status#1', '-');
            $template->setValue('cost#1', '-');
            $template->setValue('paid#1', '-');
        } else {
            foreach ($appointments as $index => $appointment) {
                $row = $index + 1;
                $doctorName = $appointment->doctor ? trim($appointment->doctor->name . ' ' . ($appointment->doctor->last_name ?? '')) : '-';
                $patientName = $appointment->patient ? trim($appointment->patient->name . ' ' . ($appointment->patient->last_name ?? '')) : '-';

                $template->setValue("no#{$row}", $row);
                $template->setValue("treatment#{$row}", $appointment->treatment->name ?? '-');
                $template->setValue("doctor#{$row}", $doctorName);
                $template->setValue("patient#{$row}", $patientName);
                $template->setValue("date#{$row}", $appointment->appointment_date ? $appointment->appointment_date->format('d/m/Y') : '-');
                $template->setValue("time#{$row}", $appointment->appointment_time ? $appointment->appointment_time->format('H:i') : '-');
                $template->setValue("status#{$row}", $appointment->status_text);
                $template->setValue("cost#{$row}", number_format($appointment->cost ?? 0, 2));
                $template->setValue("paid#{$row}", number_format($appointment->paid ?? 0, 2));
            }
        }

        $template->saveAs($filename);
    }
}
