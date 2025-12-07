<div class="alert alert-warning">
  <h5><i class="icon fas fa-exclamation-triangle"></i> <?php echo e(__('global.warning')); ?></h5>
  <?php echo e(__('global.warning_delete')); ?>

</div>

<?php
    $returnUrl = old('return_url', $returnUrl ?? request('return_url'));
?>

<form id="form-delete" action="<?php echo e(route('dental_management.appointments.deleteSave', $appointment)); ?>" method="POST" data-parsley-validate>
  <?php echo csrf_field(); ?>
  <?php echo method_field('DELETE'); ?>
  <?php if(!empty($returnUrl)): ?>
    <input type="hidden" name="return_url" value="<?php echo e($returnUrl); ?>">
  <?php endif; ?>

  <div class="form-group">
    <label for="reason"><?php echo e(__('global.delete_description')); ?> <span class="text-danger">(*)</span></label>
    <textarea name="reason" id="reason" class="form-control" rows="3" required
              placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('global.delete_description')])); ?>"></textarea>
    <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <small class="text-danger d-block"><?php echo e($message); ?></small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label><?php echo e(__('dental_management.appointments.patient')); ?></label>
        <p class="form-control-plaintext"><?php echo e($appointment->patient ? $appointment->patient->name . ' ' . $appointment->patient->last_name : '-'); ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label><?php echo e(__('dental_management.appointments.doctor')); ?></label>
        <p class="form-control-plaintext"><?php echo e($appointment->doctor ? $appointment->doctor->name . ' ' . $appointment->doctor->last_name : '-'); ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label><?php echo e(__('dental_management.appointments.treatment')); ?></label>
        <p class="form-control-plaintext"><?php echo e($appointment->treatment->name ?? '-'); ?></p>
      </div>
    </div>
  </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmDelete() {
    Swal.fire({
        title: '<?php echo e(__("global.confirm_delete")); ?>',
        text: '<?php echo e(__("global.confirm_delete_text")); ?>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '<?php echo e(__("global.yes_delete")); ?>',
        cancelButtonText: '<?php echo e(__("global.cancel")); ?>'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-delete').submit();
        }
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/appointments/partials/form_delete.blade.php ENDPATH**/ ?>