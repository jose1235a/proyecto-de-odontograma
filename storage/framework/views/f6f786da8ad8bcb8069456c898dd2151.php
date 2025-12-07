<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.created_by')); ?></label>
      <p class="form-control-plaintext"><?php echo e($appointment->creator->name ?? '-'); ?></p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.created_at')); ?></label>
      <p class="form-control-plaintext"><?php echo e($appointment->created_at ? $appointment->created_at->format('d/m/Y H:i') : '-'); ?></p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.updated_at')); ?></label>
      <p class="form-control-plaintext"><?php echo e($appointment->updated_at ? $appointment->updated_at->format('d/m/Y H:i') : '-'); ?></p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.deleted_by')); ?></label>
      <p class="form-control-plaintext"><?php echo e($appointment->deleter->name ?? '-'); ?></p>
    </div>
  </div>
</div>

<?php if($appointment->deleted_at): ?>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo e(__('global.deleted_at')); ?></label>
        <p class="form-control-plaintext"><?php echo e($appointment->deleted_at ? $appointment->deleted_at->format('d/m/Y H:i') : '-'); ?></p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label><?php echo e(__('global.deleted_reason')); ?></label>
        <p class="form-control-plaintext"><?php echo e($appointment->deleted_description ?? '-'); ?></p>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/appointments/partials/form_show_audit.blade.php ENDPATH**/ ?>