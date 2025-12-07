<?php

namespace App\Exports\DentalManagement\Treatments;

use PhpOffice\PhpWord\TemplateProcessor;

class TreatmentsWord
{
    public function generate($treatments, string $filename): void
    {
        $template = new TemplateProcessor(
            resource_path('templates/dental_management/treatments/template.docx')
        );

        $template->setValue('title', __('dental_management.treatments.plural'));
        $template->setValue('created_at', __('global.created_at'));
        $template->setValue('date', formatDateTime(now()));

        $template->setValue('header_no', __('global.no'));
        $template->setValue('header_name', __('dental_management.treatments.name'));
        $template->setValue('header_description', __('dental_management.treatments.description'));
        $template->setValue('header_state', __('dental_management.treatments.is_active'));
        $template->setValue('header_created_at', __('global.created_at'));
        $template->setValue('header_creator', __('global.created_by'));

        $template->cloneRow('no', max(count($treatments), 1));

        if ($treatments->isEmpty()) {
            $template->setValue('no#1', '1');
            $template->setValue('name#1', '-');
            $template->setValue('description#1', '-');
            $template->setValue('state#1', '-');
            $template->setValue('created_at#1', '-');
            $template->setValue('creator#1', '-');
        } else {
            foreach ($treatments as $i => $treatment) {
                $row = $i + 1;
                $template->setValue("no#{$row}", $row);
                $template->setValue("name#{$row}", $treatment->name);
                $template->setValue("description#{$row}", $treatment->description ?? '-');
                $template->setValue("state#{$row}", $treatment->state_text);
                $template->setValue("created_at#{$row}", formatDateTime($treatment->created_at));
                $template->setValue("creator#{$row}", $treatment->creator->name ?? '-');
            }
        }

        $template->saveAs($filename);
    }
}
