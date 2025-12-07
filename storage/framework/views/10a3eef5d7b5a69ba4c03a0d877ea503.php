<div class="modal fade" id="advanced-options-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-cogs"></i> <?php echo e(__('dental_management.odontogram.advanced_options_title')); ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-12 col-md-4 col-xl-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6><?php echo e($treatment->name); ?></h6>
                                    <div class="form-group mb-0">
                                        <input
                                            type="color"
                                            class="treatment-color-picker"
                                            data-treatment-id="<?php echo e($treatment->id); ?>"
                                            value="<?php echo e($treatment->color ?? '#4ecdc4'); ?>"
                                            style="width: 42px; height: 42px; padding: 0; border: none; background: transparent; cursor: pointer;"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('global.close')); ?></button>
                <button type="button" class="btn btn-primary" onclick="saveTreatmentColors()"><?php echo e(__('global.save_changes')); ?></button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/odontogram/partials/advanced_options_modal.blade.php ENDPATH**/ ?>