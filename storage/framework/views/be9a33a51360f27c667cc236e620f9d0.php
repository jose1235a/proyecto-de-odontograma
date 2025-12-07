<?php $__env->startSection('title', __('dental_management.treatments.title')); ?>
<?php $__env->startSection('title_navbar', __('dental_management.treatments.plural')); ?>

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
        <form id="treatments-filter-form" method="GET" action="<?php echo e(route('dental_management.treatments.index')); ?>">
          <?php echo $__env->make('dental_management.treatments.partials.index_filters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
      </div>
      <div class="card-footer text-center">
        <button type="button" onclick="document.getElementById('treatments-filter-form').submit()" class="btn btn-primary mr-4">
          <i class="fas fa-search"></i> <?php echo e(__('global.search')); ?>

        </button>
        <a href="<?php echo e(route('dental_management.treatments.index')); ?>" class="btn btn-default">
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
          <?php if($treatments->total() > 0): ?>
            <?php echo e($treatments->total()); ?>

          <?php else: ?>
            0
          <?php endif; ?>
        </h3>
        <div class="card-tools">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('treatments.create')): ?>
          <a class="btn btn-sm btn-primary mr-2" href="<?php echo e(route('dental_management.treatments.create')); ?>">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.create')); ?></span>
          </a>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('treatments.edit_all')): ?>
          <a class="btn btn-sm bg-olive mr-2" href="<?php echo e(route('dental_management.treatments.edit_all')); ?>">
            <i class="fas fa-edit"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.edit_all')); ?></span>
          </a>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('treatments.export')): ?>
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-file-export"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.export')); ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item text-dark" href="<?php echo e(route('dental_management.treatments.export_excel', request()->query())); ?>">
                <i class="fas fa-file-excel text-success"></i> <?php echo e(__('global.excel')); ?>

              </a>
              <a class="dropdown-item text-dark" href="<?php echo e(route('dental_management.treatments.export_pdf', request()->query())); ?>">
                <i class="fas fa-file-pdf text-danger"></i> <?php echo e(__('global.pdf')); ?>

              </a>
              <a class="dropdown-item text-dark" href="<?php echo e(route('dental_management.treatments.export_word', request()->query())); ?>">
                <i class="fas fa-file-word text-primary"></i> <?php echo e(__('global.word')); ?>

              </a>
            </div>
          </div>
          <?php endif; ?>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <?php echo $__env->make('dental_management.treatments.partials.index_results', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
      </div>
      <div class="card-footer">
        <div class="d-flex justify-content-end">
          <?php echo e($treatments->links()); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('dental_management.treatments.partials.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/treatments/index.blade.php ENDPATH**/ ?>