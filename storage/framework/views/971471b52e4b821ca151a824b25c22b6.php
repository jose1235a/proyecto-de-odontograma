<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.created_by')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->creator->name ?? '-'); ?></p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.created_at')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->created_at ? $patient->created_at->format('d/m/Y H:i') : '-'); ?></p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.updated_at')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->updated_at ? $patient->updated_at->format('d/m/Y H:i') : '-'); ?></p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.deleted_by')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->deleter->name ?? '-'); ?></p>
    </div>
  </div>
</div>

<?php if($patient->deleted_at): ?>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.deleted_at')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->deleted_at ? $patient->deleted_at->format('d/m/Y H:i') : '-'); ?></p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo e(__('global.deleted_reason')); ?></label>
      <p class="form-control-plaintext"><?php echo e($patient->deleted_description ?? '-'); ?></p>
    </div>
  </div>
</div>
<?php endif; ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/partials/form_show_audit.blade.php ENDPATH**/ ?>