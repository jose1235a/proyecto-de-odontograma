@php
$legacyTreatmentLabels = [
    'cavity' => __('dental_management.odontogram.tool_cavity'),
    'filling' => __('dental_management.odontogram.tool_filling'),
    'crown' => __('dental_management.odontogram.tool_crown'),
    'extraction' => __('dental_management.odontogram.tool_extraction'),
    'implant' => __('dental_management.odontogram.tool_implant'),
    'bridge' => 'Bridge',
    'denture' => 'Denture',
    'root_canal' => 'Root canal',
    'fracture' => 'Fracture',
    'abscess' => 'Abscess',
    'gingivitis' => 'Gingivitis',
    'periodontitis' => 'Periodontitis',
];
@endphp
<script>
window.odontogramEditorConfig = {
    initialData: @json($initialData ?? []),
    treatments: @json($treatments ?? []),
    slug: '{{ $odontogram->slug ?? '' }}',
    odontogramId: @json($odontogram->id ?? null),
    translations: {
        toothLabel: @json(__('dental_management.odontogram.tooth_label')),
        actionSaved: @json(__('dental_management.odontogram.action_saved')),
        actionError: @json(__('dental_management.odontogram.action_save_error')),
        surfaceLabels: @json(__('dental_management.odontogram.surfaces')),
        legacyTreatmentLabels: @json($legacyTreatmentLabels),
    },
    messages: {
        errorOccurred: @json(__('global.error_occurred')),
        errorTitle: @json(__('global.error')),
        successTitle: @json(__('global.success')),
    },
    routes: {
        updateColors: '{{ route("dental_management.treatments.update_colors") }}',
        updateOdontogram: '{{ route("dental_management.odontogram.update", ":slug") }}',
    },
};
</script>
<script type="module" src="{{ asset('adminlte/js/odontogram/editor-bootstrap.js') }}"></script>
