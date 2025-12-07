<form id="form-save" action="<?php echo e(route('dental_management.treatments.store')); ?>" method="POST" data-parsley-validate>
  <?php echo csrf_field(); ?>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="name"><?php echo e(__('dental_management.treatments.name')); ?> <span class="text-danger">(*)</span></label>
        <input type="text" name="name" id="name" class="form-control"
               value="<?php echo e(old('name')); ?>" required>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="cost"><?php echo e(__('dental_management.treatments.cost')); ?> <span class="text-danger">(*)</span></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">$</span>
          </div>
          <input type="number" name="cost" id="cost" class="form-control"
                 value="<?php echo e(old('cost')); ?>" step="0.01" min="0" max="999999.99" required>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="color"><?php echo e(__('dental_management.treatments.color')); ?></label>
        <input type="color" name="color" id="color" class="form-control"
               value="<?php echo e(old('color', '#007bff')); ?>" style="height: 38px;">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="coverage"><?php echo e(__('dental_management.treatments.coverage')); ?> <span class="text-danger">(*)</span></label>
        <select name="coverage" id="coverage" class="form-control" required>
          <option value="partial" <?php echo e(old('coverage', 'partial') === 'partial' ? 'selected' : ''); ?>>
            <?php echo e(__('dental_management.treatments.coverage_partial')); ?>

          </option>
          <option value="full" <?php echo e(old('coverage') === 'full' ? 'selected' : ''); ?>>
            <?php echo e(__('dental_management.treatments.coverage_full')); ?>

          </option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="description"><?php echo e(__('dental_management.treatments.description')); ?></label>
    <textarea name="description" id="description" class="form-control" rows="4"><?php echo e(old('description')); ?></textarea>
  </div>
</form>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/treatments/partials/form_create.blade.php ENDPATH**/ ?>