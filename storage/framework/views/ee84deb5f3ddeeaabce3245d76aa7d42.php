<?php $__env->startSection('title', __('dental_management.appointments.delete_title')); ?>
<?php $__env->startSection('title_navbar', __('dental_management.appointments.plural')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-danger rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-trash"></i> <?php echo e(__('global.delete')); ?>

        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <?php echo $__env->make('dental_management.appointments.partials.form_delete', [
            'returnUrl' => request('return_url'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="card-footer text-center">
        <button type="button" onclick="confirmDelete()" class="btn btn-danger mr-4">
          <i class="fas fa-trash"></i> <?php echo e(__('global.destroy')); ?>

        </button>
        <a href="<?php echo e(request('return_url', route('dental_management.appointments.index'))); ?>" class="btn btn-default">
          <i class="fas fa-times"></i> <?php echo e(__('global.cancel')); ?>

        </a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/appointments/delete.blade.php ENDPATH**/ ?>