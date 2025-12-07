<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="name" class="required"><?php echo e(__('dental_management.specialties.name')); ?></label>
      <input type="text" class="form-control" id="name" name="name"
             value="<?php echo e(old('name')); ?>" required
             placeholder="<?php echo e(__('global.placeholders.enter_attribute', ['attribute' => __('dental_management.specialties.name')])); ?>">
      <?php $__errorArgs = ['name'];
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
  </div>
</div>

<input type="hidden" name="is_active" value="1"><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/specialties/partials/form_create.blade.php ENDPATH**/ ?>