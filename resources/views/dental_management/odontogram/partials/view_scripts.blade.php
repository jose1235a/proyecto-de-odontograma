@php
    $historyConfig = [
        'historyUrl' => route('dental_management.treatment_history.index'),
        'odontogramId' => $odontogram->id,
        'panelId' => 'odontogram-treatment-history',
        'badgeId' => 'odontogram-history-count',
        'template' => 'table',
        'columns' => 3,
        'translations' => [
            'errorText' => __('global.error_loading_data'),
            'noRecords' => __('global.no_records'),
            'doctorNotSpecified' => __('dental_management.odontogram.doctor_not_specified'),
            'surfaceLabels' => __('dental_management.odontogram.surfaces'),
            'fullSurfaceLabel' => __('dental_management.odontogram.surface_whole_tooth'),
            'actionLabels' => [
                'applied' => __('dental_management.treatment_history.action_applied'),
                'cleared' => __('dental_management.treatment_history.action_cleared'),
            ],
            'toothLabel' => __('dental_management.odontogram.tooth_label'),
        ],
    ];

    $viewerConfig = [
        'initialData' => $initialData ?? [],
        'canvasId' => 'odontogram-canvas',
        'historyButtonsSelector' => '.load-history',
    ];
@endphp
<script>
    window.odontogramViewConfig = @json($historyConfig);
    window.treatmentHistoryPanels = window.treatmentHistoryPanels || [];
    if (typeof window.registerTreatmentHistoryPanel === 'function') {
        window.registerTreatmentHistoryPanel(window.odontogramViewConfig);
    } else {
        window.treatmentHistoryPanels.push(window.odontogramViewConfig);
    }
    window.odontogramViewerConfig = @json($viewerConfig);
</script>
<script type="module" src="{{ asset('adminlte/js/odontogram/view-history.js') }}"></script>
<script type="module" src="{{ asset('adminlte/js/odontogram/viewer.js') }}"></script>
