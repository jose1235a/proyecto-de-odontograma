<?php

namespace App\Exports\DentalManagement\Doctors;

use PhpOffice\PhpWord\TemplateProcessor;

class DoctorsWord
{
    public function generate($doctors, string $filename): void
    {
        $template = new TemplateProcessor(
            resource_path('templates/dental_management/doctors/template.docx')
        );

        $template->setValue('title', __('dental_management.doctors.plural'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        $template->setValue('header_no', __('global.no'));
        $template->setValue('header_name', __('dental_management.doctors.name'));
        $template->setValue('header_last_name', __('dental_management.doctors.last_name'));
        $template->setValue('header_email', __('dental_management.doctors.email'));
        $template->setValue('header_phone', __('dental_management.doctors.phone'));
        $template->setValue('header_document', __('dental_management.doctors.document'));
        $template->setValue('header_state', __('dental_management.doctors.is_active'));
        $template->setValue('header_created_at', __('global.created_at'));
        $template->setValue('header_creator', __('global.created_by'));

        $template->cloneRow('no', count($doctors));
        foreach ($doctors as $i => $doctor) {
            $row = $i + 1;
            $template->setValue("no#{$row}", $row);
            $template->setValue("name#{$row}", $doctor->name);
            $template->setValue("last_name#{$row}", $doctor->last_name ?? '-');
            $template->setValue("email#{$row}", $doctor->email);
            $template->setValue("phone#{$row}", $doctor->phone ?? '-');
            $template->setValue("document#{$row}", trim(strtoupper($doctor->document_type ?? '') . ' ' . ($doctor->document ?? '-')));
            $template->setValue("state#{$row}", $doctor->state_text);
            $template->setValue("created_at#{$row}", formatDateTime($doctor->created_at));
            $template->setValue("creator#{$row}", $doctor->creator->name ?? '-');
        }

        $template->saveAs($filename);
    }
}
