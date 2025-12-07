<?php
    $fullName = trim($patient->name . ' ' . ($patient->last_name ?? ''));
    $warningConditions = [
        [
            'visible' => $patient->under_medical_treatment,
            'label' => __('dental_management.patients.conditions.under_medical_treatment'),
            'value' => $patient->under_medical_treatment_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->prone_to_bleeding,
            'label' => __('dental_management.patients.conditions.prone_to_bleeding'),
            'value' => $patient->prone_to_bleeding_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->allergic_to_medication,
            'label' => __('dental_management.patients.conditions.allergic_to_medication'),
            'value' => $patient->allergic_to_medication_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->hypertensive,
            'label' => __('dental_management.patients.conditions.hypertensive'),
            'value' => $patient->hypertensive_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->diabetic,
            'label' => __('dental_management.patients.conditions.diabetic'),
            'value' => $patient->diabetic_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->pregnant,
            'label' => __('dental_management.patients.conditions.pregnant'),
            'value' => $patient->pregnant_description ?: __('global.yes'),
        ],
    ];
    $warningConditions = array_values(array_filter($warningConditions, fn ($condition) => $condition['visible']));
?>

<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label><?php echo e(__('dental_management.patients.email')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->email ?? '-'); ?></p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label><?php echo e(__('dental_management.patients.address')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->address ?? '-'); ?></p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label><?php echo e(__('dental_management.patients.emergency_contact')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->emergency_contact ?? '-'); ?></p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label><?php echo e(__('dental_management.patients.birth_date')); ?></label>
      <p class="form-control-plaintext">
        <?php echo e($patient->birth_date ? $patient->birth_date->format('d/m/Y') : '-'); ?>

      </p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label><?php echo e(__('dental_management.patients.total_debt')); ?></label>
      <p class="form-control-plaintext">
        <?php if($patient->total_debt > 0): ?>
          <span class="text-danger font-weight-bold"><?php echo e($patient->total_debt_formatted); ?></span>
        <?php else: ?>
          <span class="text-success"><?php echo e(__('dental_management.patients.no_debt')); ?></span>
        <?php endif; ?>
      </p>
    </div>
  </div>
  <div class="col-md-9">
    <!-- Reserved space for additional financial information -->
  </div>
</div>

<?php if(count($warningConditions)): ?>
  <?php $__currentLoopData = array_chunk($warningConditions, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="row">
      <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3">
          <p class="form-control-plaintext">
            <i class="fas fa-exclamation-triangle text-warning"></i>
            <strong><?php echo e($condition['label']); ?>:</strong>
            <span class="text-danger font-weight-bold"><?php echo e($condition['value']); ?></span>
          </p>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label><?php echo e(__('dental_management.patients.observations')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->observations ?: '-'); ?></p>
    </div>
  </div>
</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/partials/form_show.blade.php ENDPATH**/ ?>