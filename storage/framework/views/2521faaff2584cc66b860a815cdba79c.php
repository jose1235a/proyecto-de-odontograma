

<?php $__env->startSection('title', __('dental_management.specialties.create_title')); ?>
<?php $__env->startSection('title_navbar', __('dental_management.specialties.plural')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-plus"></i> <?php echo e(__('dental_management.specialties.create_title')); ?>

        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <form id="form-save" method="POST" action="<?php echo e(route('dental_management.specialties.store')); ?>" data-parsley-validate>
          <?php echo csrf_field(); ?>
          <?php echo $__env->make('dental_management.specialties.partials.form_create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> <?php echo e(__('global.save')); ?>

        </button>
        <a href="<?php echo e(route('dental_management.specialties.index')); ?>" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> <?php echo e(__('global.back')); ?>

        </a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('adminlte/js/dental_specialties.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/specialties/create.blade.php ENDPATH**/ ?>