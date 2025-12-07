<?php

// Namespace
namespace App\Exports\DentalManagement\Patients;

// Word Library
use PhpOffice\PhpWord\TemplateProcessor;

// Main class
class PatientsWord
{
    // Generate Word
    public function generate($patients, string $filename): void
    {
        // Create template
        $template = new TemplateProcessor(
            resource_path('templates/dental_management/patients/template.docx')
        );

        // Title and date
        $template->setValue('title',  __('dental_management.patients.plural'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        // Columns
        $template->setValue('header_no', __('global.no'));
        $template->setValue('header_name', __('dental_management.patients.name'));
        $template->setValue('header_last_name', __('dental_management.patients.last_name'));
        $template->setValue('header_email', __('dental_management.patients.email'));
        $template->setValue('header_phone', __('dental_management.patients.phone'));
        $template->setValue('header_document', __('dental_management.patients.document'));
        $template->setValue('header_state', __('dental_management.patients.is_active'));
        $template->setValue('header_created_at', __('global.created_at'));
        $template->setValue('header_creator', __('global.created_by'));

        // Rows
        $template->cloneRow('no', count($patients));
        foreach ($patients as $i => $patient) {
            $row = $i + 1;
            $template->setValue("no#{$row}", $row);
            $template->setValue("name#{$row}", $patient->name);
            $template->setValue("last_name#{$row}", $patient->last_name ?? '-');
            $template->setValue("email#{$row}", $patient->email);
            $template->setValue("phone#{$row}", $patient->phone ?? '-');
            $template->setValue("document#{$row}", $patient->document ?? '-');
            $template->setValue("state#{$row}", $patient->state_text);
            $template->setValue("created_at#{$row}", formatDateTime($patient->created_at));
            $template->setValue("creator#{$row}", $patient->creator->name ?? '-');
        }

        // Save to provided path
        $template->saveAs($filename);
    }
}