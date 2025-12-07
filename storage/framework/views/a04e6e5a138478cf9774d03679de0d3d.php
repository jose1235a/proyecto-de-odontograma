<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="name"><?php echo e(__('dental_management.doctors.name')); ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e(request('name')); ?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="last_name"><?php echo e(__('dental_management.doctors.last_name')); ?></label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo e(request('last_name')); ?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="document"><?php echo e(__('dental_management.doctors.document')); ?></label>
            <input type="text" class="form-control" id="document" name="document" value="<?php echo e(request('document')); ?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="specialty_id"><?php echo e(__('dental_management.doctors.specialty')); ?></label>
            <select class="form-control" id="specialty_id" name="specialty_id">
                <option value=""><?php echo e(__('global.select_option')); ?></option>
                <?php $__currentLoopData = $specialties ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($specialty->id); ?>" <?php echo e(request('specialty_id') == $specialty->id ? 'selected' : ''); ?>>
                        <?php echo e($specialty->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/doctors/partials/index_filters.blade.php ENDPATH**/ ?>