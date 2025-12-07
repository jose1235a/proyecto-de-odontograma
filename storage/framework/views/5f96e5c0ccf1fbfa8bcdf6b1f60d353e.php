<?php
    $patient ??= null;
    $patientAge = $patient && $patient->birth_date ? $patient->birth_date->age : null;
    $patientFullName = $patient
        ? trim(($patient->name ?? '') . ' ' . ($patient->last_name ?? ''))
        : '';
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label><strong><?php echo e(__('dental_management.patients.name')); ?> / <?php echo e(__('dental_management.patients.last_name')); ?>:</strong></label>
                    <p class="form-control-plaintext"><?php echo e($patientFullName !== '' ? $patientFullName : __('global.not_specified')); ?></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label><strong><?php echo e(__('dental_management.patients.document')); ?>:</strong></label>
                    <p class="form-control-plaintext"><?php echo e($patient->document ?? __('global.not_specified')); ?></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label><strong><?php echo e(__('dental_management.patients.age')); ?>:</strong></label>
                    <p class="form-control-plaintext"><?php echo e($patientAge !== null ? $patientAge : __('global.not_specified')); ?></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label><strong><?php echo e(__('dental_management.patients.phone')); ?>:</strong></label>
                    <p class="form-control-plaintext"><?php echo e($patient->phone ?? __('global.not_specified')); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/odontogram/partials/patient_info.blade.php ENDPATH**/ ?>