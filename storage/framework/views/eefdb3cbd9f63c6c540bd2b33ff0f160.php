<?php $__env->startSection('title', __('dental_management.payments.delete_title')); ?>
<?php $__env->startSection('title_navbar', __('dental_management.payments.plural')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-danger rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-trash"></i> <?php echo e(__('dental_management.payments.delete_title')); ?>

        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="alert alert-warning">
          <h5><i class="icon fas fa-exclamation-triangle"></i> <?php echo e(__('global.warning')); ?>!</h5>
          <?php echo e(__('dental_management.payments.delete_warning')); ?>

        </div>

        <div class="row">
          <div class="col-md-6">
            <dl class="row">
              <dt class="col-sm-4"><?php echo e(__('dental_management.payments.fields.patient')); ?>:</dt>
              <dd class="col-sm-8"><?php echo e($payment->patient->name ?? '-'); ?></dd>

              <dt class="col-sm-4"><?php echo e(__('dental_management.payments.fields.amount')); ?>:</dt>
              <dd class="col-sm-8">S/ <?php echo e(number_format($payment->amount, 2)); ?></dd>

              <dt class="col-sm-4"><?php echo e(__('dental_management.payments.fields.payment_date')); ?>:</dt>
              <dd class="col-sm-8"><?php echo e($payment->payment_date->format('d/m/Y')); ?></dd>
            </dl>
          </div>
          <div class="col-md-6">
            <dl class="row">
              <dt class="col-sm-4"><?php echo e(__('dental_management.payments.fields.payment_method')); ?>:</dt>
              <dd class="col-sm-8"><?php echo $payment->payment_method_html; ?></dd>

              <dt class="col-sm-4"><?php echo e(__('dental_management.payments.fields.status')); ?>:</dt>
              <dd class="col-sm-8"><?php echo $payment->status_html; ?></dd>
            </dl>
          </div>
        </div>

        <?php echo $__env->make('dental_management.payments.partials.form_delete', ['returnUrl' => $returnUrl ?? null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-delete" class="btn btn-danger mr-4">
          <i class="fas fa-trash"></i> <?php echo e(__('global.delete')); ?>

        </button>
        <a href="<?php echo e($backUrl ?? route('dental_management.payments.index')); ?>" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> <?php echo e(__('global.cancel')); ?>

        </a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('dental_management.payments.partials.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/payments/delete.blade.php ENDPATH**/ ?>