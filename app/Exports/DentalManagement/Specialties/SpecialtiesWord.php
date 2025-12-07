<?php

namespace App\Exports\DentalManagement\Specialties;

use PhpOffice\PhpWord\TemplateProcessor;

class SpecialtiesWord
{
    public function generate($specialties, string $filename): void
    {
        $template = new TemplateProcessor(
            resource_path('templates/dental_management/specialties/template.docx')
        );

        $template->setValue('title',  __('dental_management.specialties.plural'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        $template->setValue('header_no', __('global.no'));
        $template->setValue('header_name', __('dental_management.specialties.name'));
        $template->setValue('header_description', __('dental_management.specialties.description'));
        $template->setValue('header_state', __('dental_management.specialties.is_active'));
        $template->setValue('header_created_at', __('global.created_at'));
        $template->setValue('header_creator', __('global.created_by'));

        $template->cloneRow('no', count($specialties));
        foreach ($specialties as $i => $specialty) {
            $row = $i + 1;
            $template->setValue("no#{$row}", $row);
            $template->setValue("name#{$row}", $specialty->name);
            $template->setValue("description#{$row}", $specialty->description ?? '-');
            $template->setValue("state#{$row}", $specialty->state_text);
            $template->setValue("created_at#{$row}", formatDateTime($specialty->created_at));
            $template->setValue("creator#{$row}", $specialty->creator->name ?? '-');
        }

        $template->saveAs($filename);
    }
}
