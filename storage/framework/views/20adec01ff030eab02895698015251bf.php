<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="document"><?php echo e(__('dental_management.patients.document')); ?></label>
            <input type="text" class="form-control" id="document" name="document"
                   value="<?php echo e(request('document')); ?>" placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.document')])); ?>">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="name"><?php echo e(__('dental_management.patients.name')); ?></label>
            <input type="text" class="form-control" id="name" name="name"
                   value="<?php echo e(request('name')); ?>" placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.name')])); ?>">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="is_active"><?php echo e(__('dental_management.patients.is_active')); ?></label>
            <select class="form-control" id="is_active" name="is_active">
                <option value=""><?php echo e(__('global.all')); ?></option>
                <option value="1" <?php echo e(request('is_active') == '1' ? 'selected' : ''); ?>><?php echo e(__('global.active')); ?></option>
                <option value="0" <?php echo e(request('is_active') == '0' ? 'selected' : ''); ?>><?php echo e(__('global.inactive')); ?></option>
            </select>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/partials/index_filters.blade.php ENDPATH**/ ?>