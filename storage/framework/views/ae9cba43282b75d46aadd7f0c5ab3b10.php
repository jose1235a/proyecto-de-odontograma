<?php $__env->startSection('title', __('dental_management.payments.create_title')); ?>
<?php $__env->startSection('title_navbar', __('dental_management.payments.plural')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-success rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-plus"></i> <?php echo e(__('dental_management.payments.create_title')); ?>

        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <?php echo $__env->make('dental_management.payments.partials.form_create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-success mr-4">
          <i class="fas fa-save"></i> <?php echo e(__('global.save')); ?>

        </button>
        <?php if(request()->has('patient_id')): ?>
          <?php
            $patientId = request()->patient_id;
            $patient = \App\Models\Patient::where('slug', $patientId)->first() ?? \App\Models\Patient::find($patientId);
            $redirectSlug = $patient ? $patient->slug : null;
          ?>
          <?php if($redirectSlug): ?>
            <a href="<?php echo e(route('dental_management.patients.show', $redirectSlug)); ?>" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> <?php echo e(__('global.back')); ?>

            </a>
          <?php else: ?>
            <a href="<?php echo e(route('dental_management.payments.index')); ?>" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> <?php echo e(__('global.back')); ?>

            </a>
          <?php endif; ?>
        <?php else: ?>
          <a href="<?php echo e(route('dental_management.payments.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> <?php echo e(__('global.back')); ?>

          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('dental_management.payments.partials.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/payments/create.blade.php ENDPATH**/ ?>