<form id="form-delete" action="<?php echo e(route('dental_management.payments.deleteSave', $payment)); ?>" method="POST">
  <?php echo csrf_field(); ?>
  <?php echo method_field('DELETE'); ?>
  <?php if(!empty($returnUrl)): ?>
  <input type="hidden" name="return_url" value="<?php echo e($returnUrl); ?>">
  <?php endif; ?>

  <div class="form-group">
    <label for="reason"><?php echo e(__('dental_management.payments.fields.delete_reason')); ?> <span class="text-danger">(*)</span></label>
    <textarea name="reason" id="reason" class="form-control" rows="4" required
              placeholder="<?php echo e(__('global.placeholders.enter_delete_reason')); ?>"
              minlength="10" maxlength="500"></textarea>
    <small class="form-text text-muted"><?php echo e(__('global.min_characters', ['count' => 10])); ?></small>
    <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
  </div>
</form><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/payments/partials/form_delete.blade.php ENDPATH**/ ?>