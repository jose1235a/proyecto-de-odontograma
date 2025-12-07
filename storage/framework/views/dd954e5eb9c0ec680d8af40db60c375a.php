<?php $__env->startSection('title', __('dental_management.payments.title')); ?>

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
        <form id="payments-filter-form" method="GET" action="<?php echo e(route('dental_management.payments.index')); ?>">
          <?php echo $__env->make('dental_management.payments.partials.index_filters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="payments-filter-form" class="btn btn-primary mr-4">
          <i class="fas fa-search"></i> <?php echo e(__('global.search')); ?>

        </button>
        <a href="<?php echo e(route('dental_management.payments.index')); ?>" class="btn btn-default">
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
          <?php if($payments->total() > 0): ?>
            <?php echo e($payments->total()); ?>

          <?php else: ?>
            0
          <?php endif; ?>
        </h3>
        <div class="card-tools">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payments.create')): ?>
          <a class="btn btn-sm btn-primary mr-2" href="<?php echo e(route('dental_management.payments.create')); ?>">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.create')); ?></span>
          </a>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payments.edit_all')): ?>
          <a class="btn btn-sm bg-olive mr-2" href="<?php echo e(route('dental_management.payments.edit_all')); ?>">
            <i class="fas fa-edit"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.edit_all')); ?></span>
          </a>
          <?php endif; ?>
          <!-- Export Dropdown -->
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payments.export')): ?>
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-file-export"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.export')); ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item text-dark" href="<?php echo e(route('dental_management.payments.export_excel', request()->query())); ?>">
                <i class="fas fa-file-excel text-success"></i> <?php echo e(__('global.excel')); ?>

              </a>
              <a class="dropdown-item text-dark" href="<?php echo e(route('dental_management.payments.export_pdf', request()->query())); ?>">
                <i class="fas fa-file-pdf text-danger"></i> <?php echo e(__('global.pdf')); ?>

              </a>
              <a class="dropdown-item text-dark" href="<?php echo e(route('dental_management.payments.export_word', request()->query())); ?>">
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
          <?php echo $__env->make('dental_management.payments.partials.index_results', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
      </div>
      <div class="card-footer">
        <div class="d-flex justify-content-end">
          <?php echo e($payments->links()); ?>

        </div>
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
<script src="<?php echo e(asset('adminlte/js/dental_payments.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/payments/index.blade.php ENDPATH**/ ?>