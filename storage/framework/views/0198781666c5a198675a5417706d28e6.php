<?php $__env->startSection('title', __('regions.create_title')); ?>
<?php $__env->startSection('title_navbar', __('regions.singular')); ?>

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
        <?php echo $__env->make('system_management.regions.partials.form_create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> <?php echo e(__('global.save')); ?>

        </button>
        <a href="<?php echo e(route('system_management.regions.index')); ?>" class="btn btn-default">
          <i class="fas fa-times"></i> <?php echo e(__('global.cancel')); ?>

        </a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/system_management/regions/create.blade.php ENDPATH**/ ?>