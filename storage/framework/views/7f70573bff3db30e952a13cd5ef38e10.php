<?php
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
?>
<script>
window.odontogramEditorConfig = {
    initialData: <?php echo json_encode($initialData ?? [], 15, 512) ?>,
    treatments: <?php echo json_encode($treatments ?? [], 15, 512) ?>,
    slug: '<?php echo e($odontogram->slug ?? ''); ?>',
    odontogramId: <?php echo json_encode($odontogram->id ?? null, 15, 512) ?>,
    translations: {
        toothLabel: <?php echo json_encode(__('dental_management.odontogram.tooth_label'), 15, 512) ?>,
        actionSaved: <?php echo json_encode(__('dental_management.odontogram.action_saved'), 15, 512) ?>,
        actionError: <?php echo json_encode(__('dental_management.odontogram.action_save_error'), 15, 512) ?>,
        surfaceLabels: <?php echo json_encode(__('dental_management.odontogram.surfaces'), 15, 512) ?>,
        legacyTreatmentLabels: <?php echo json_encode($legacyTreatmentLabels, 15, 512) ?>,
    },
    messages: {
        errorOccurred: <?php echo json_encode(__('global.error_occurred'), 15, 512) ?>,
        errorTitle: <?php echo json_encode(__('global.error'), 15, 512) ?>,
        successTitle: <?php echo json_encode(__('global.success'), 15, 512) ?>,
    },
    routes: {
        updateColors: '<?php echo e(route("dental_management.treatments.update_colors")); ?>',
        updateOdontogram: '<?php echo e(route("dental_management.odontogram.update", ":slug")); ?>',
    },
};
</script>
<script type="module" src="<?php echo e(asset('adminlte/js/odontogram/editor-bootstrap.js')); ?>"></script>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/odontogram/partials/create_scripts.blade.php ENDPATH**/ ?>