<form id="form-save" action="<?php echo e(route('system_management.languages.index')); ?>" method="GET">
  <div class="row">
    <div class="col-md-6">
      <label for="name" class="form-label"><?php echo e(__('languages.name')); ?></label>
      <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('languages.name')])); ?>"
             value="<?php echo e(request('name')); ?>">
    </div>

    <div class="col-md-6">
      <label for="is_active" class="form-label"><?php echo e(__('languages.is_active')); ?></label>
      <select name="is_active" id="is_active" class="form-control">
        <option value=""><?php echo e(__('global.all')); ?></option>
        <option value="1" <?php echo e(request('is_active') == '1' ? 'selected' : ''); ?>><?php echo e(__('global.active')); ?></option>
        <option value="0" <?php echo e(request('is_active') == '0' ? 'selected' : ''); ?>><?php echo e(__('global.inactive')); ?></option>
      </select>
    </div>
  </div>
</form><?php /**PATH C:\laragon\www\blog_main_base\resources\views/system_management/languages/partials/index_filters.blade.php ENDPATH**/ ?>