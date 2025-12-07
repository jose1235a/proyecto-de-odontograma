<form id="form-save" action="<?php echo e(route('system_management.regions.store')); ?>" method="POST" data-parsley-validate>
  <?php echo csrf_field(); ?>

  <div class="form-group">
    <label for="name"><?php echo e(__('regions.name')); ?> <span class="text-danger">(*)</span></label>
    <input type="text" name="name" id="name" class="form-control" required data-parsley-minlength="3" placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('regions.name')])); ?>">
  </div>
</form>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/system_management/regions/partials/form_create.blade.php ENDPATH**/ ?>