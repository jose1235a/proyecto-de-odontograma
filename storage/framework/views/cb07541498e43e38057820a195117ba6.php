<?php $__env->startSection('title', __('dental_management.appointments.create_title')); ?>
<?php $__env->startSection('title_navbar', __('dental_management.appointments.plural')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-plus"></i> <?php echo e(__('global.create')); ?>

        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <?php echo $__env->make('dental_management.appointments.partials.form_fields', [
            'formAction' => route('dental_management.appointments.store'),
            'method' => 'POST',
            'appointment' => null,
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="appointment-form" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> <?php echo e(__('global.save')); ?>

        </button>
        <?php if(request()->has('patient_id')): ?>
          <?php
            $patientId = request()->patient_id;
            $patient = \App\Models\Patient::where('slug', $patientId)->first() ?? \App\Models\Patient::find($patientId);
            $redirectSlug = $patient ? $patient->slug : null;
          ?>
          <?php if($redirectSlug): ?>
            <a href="<?php echo e(route('dental_management.patients.show', $redirectSlug)); ?>" class="btn btn-default">
              <i class="fas fa-times"></i> <?php echo e(__('global.cancel')); ?>

            </a>
          <?php else: ?>
            <a href="<?php echo e(route('dental_management.appointments.index')); ?>" class="btn btn-default">
              <i class="fas fa-times"></i> <?php echo e(__('global.cancel')); ?>

            </a>
          <?php endif; ?>
        <?php else: ?>
          <a href="<?php echo e(route('dental_management.appointments.index')); ?>" class="btn btn-default">
            <i class="fas fa-times"></i> <?php echo e(__('global.cancel')); ?>

          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Ensure Select2 dropdown opens downward */
.select2-container--bootstrap4 .select2-dropdown {
    border-color: #ced4da;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.select2-container--bootstrap4 .select2-results__option--highlighted {
    background-color: #007bff;
    color: white;
}

.select2-container--bootstrap4 .select2-selection__clear {
    color: #6c757d;
    cursor: pointer;
    float: right;
    font-weight: bold;
    margin-right: 30px;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('dental_management.appointments.partials.form_scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/appointments/create.blade.php ENDPATH**/ ?>