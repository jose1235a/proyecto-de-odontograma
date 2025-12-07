<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="name"><?php echo e(__('dental_management.treatments.name')); ?></label>
      <input
        type="text"
        name="name"
        id="name"
        class="form-control"
        value="<?php echo e(request('name')); ?>"
        placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.treatments.name')])); ?>"
      >
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="is_active"><?php echo e(__('dental_management.treatments.is_active')); ?></label>
      <select name="is_active" id="is_active" class="form-control">
        <option value=""><?php echo e(__('global.all')); ?></option>
        <option value="1" <?php echo e(request('is_active') === '1' ? 'selected' : ''); ?>><?php echo e(__('global.active')); ?></option>
        <option value="0" <?php echo e(request('is_active') === '0' ? 'selected' : ''); ?>><?php echo e(__('global.inactive')); ?></option>
      </select>
    </div>
  </div>
</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/treatments/partials/index_filters.blade.php ENDPATH**/ ?>