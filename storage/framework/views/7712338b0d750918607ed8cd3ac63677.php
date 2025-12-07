

<?php $__env->startSection('title', __('dental_management.patients.edit_all_title')); ?>
<?php $__env->startSection('title_navbar', __('dental_management.patients.plural')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-filter"></i> <?php echo e(__('global.card_title_filter')); ?>

        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <?php echo $__env->make('dental_management.patients.partials.index_filters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="card-footer text-center">
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary mr-4">
          <i class="fas fa-search"></i> <?php echo e(__('global.search')); ?>

        </button>
        <a href="<?php echo e(route('dental_management.patients.edit_all')); ?>" class="btn btn-default">
          <i class="fas fa-brush"></i> <?php echo e(__('global.clear')); ?>

        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title pt-1">
          <i class="fas fa-table"></i> <?php echo e(__('global.card_title_result')); ?>:
          <?php if($patients->total() > 0): ?>
            <?php echo e($patients->total()); ?>

          <?php else: ?>
            0
          <?php endif; ?>
        </h3>
        <div class="card-tools">
          <a class="btn btn-sm btn-primary mr-2" href="<?php echo e(route('dental_management.patients.create')); ?>">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.create')); ?></span>
          </a>
          <a class="btn btn-sm bg-olive mr-2" href="<?php echo e(route('dental_management.patients.index')); ?>">
            <i class="fas fa-list"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.view_list')); ?></span>
          </a>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <?php echo $__env->make('dental_management.patients.partials.edit_all_results', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('layouts.plugins.parsley', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dental_management.patients.partials.edit_all_scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/edit_all.blade.php ENDPATH**/ ?>