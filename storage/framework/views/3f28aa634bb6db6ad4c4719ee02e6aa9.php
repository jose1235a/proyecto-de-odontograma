<?php $__env->startSection('title', __('regions.index_title')); ?>
<?php $__env->startSection('title_navbar', __('regions.plural')); ?>

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
        <?php echo $__env->make('system_management.regions.partials.index_filters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="card-footer text-center">
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary mr-4">
          <i class="fas fa-search"></i> <?php echo e(__('global.search')); ?>

        </button>
        <a href="<?php echo e(route('system_management.regions.index')); ?>" class="btn btn-default">
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
          <?php if($regions->total() > 0): ?>
            <?php echo e($regions->total()); ?>

          <?php else: ?>
            0
          <?php endif; ?>
        </h3>
        <div class="card-tools">
          <a class="btn btn-sm btn-primary mr-2" href="<?php echo e(route('system_management.regions.create')); ?>">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.create')); ?></span>
          </a>
          <a class="btn btn-sm bg-olive mr-2" href="<?php echo e(route('system_management.regions.edit_all')); ?>">
            <i class="fas fa-edit"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.edit_all')); ?></span>
          </a>
          <!-- Export Dropdown -->
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-file-export"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.export')); ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item text-dark" href="<?php echo e(route('system_management.regions.export_excel', request()->query())); ?>">
                <i class="fas fa-file-excel text-success"></i> <?php echo e(__('global.excel')); ?>

              </a>
              <a class="dropdown-item text-dark" href="<?php echo e(route('system_management.regions.export_pdf', request()->query())); ?>">
                <i class="fas fa-file-pdf text-danger"></i> <?php echo e(__('global.pdf')); ?>

              </a>
              <a class="dropdown-item text-dark" href="<?php echo e(route('system_management.regions.export_word', request()->query())); ?>">
                <i class="fas fa-file-word text-primary"></i> <?php echo e(__('global.word')); ?>

              </a>
            </div>
          </div>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <?php echo $__env->make('system_management.regions.partials.index_results', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/system_management/regions/index.blade.php ENDPATH**/ ?>