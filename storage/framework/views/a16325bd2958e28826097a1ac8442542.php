<div class="modal fade" id="odontogram-legend-modal" tabindex="-1" role="dialog" aria-labelledby="odontogramLegendLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="odontogramLegendLabel"><?php echo e(__('dental_management.odontogram.legend')); ?></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php if($treatments->count()): ?>
                    <div class="row">
                        <?php $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6 col-md-4 col-lg-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="odontogram-legend-swatch mr-3" style="background-color:<?php echo e($treatment->color ?? '#4ecdc4'); ?>;"></span>
                                    <div>
                                        <span class="d-block font-weight-bold"><?php echo e($treatment->name); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0"><?php echo e(__('global.no_records')); ?></p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('global.close')); ?></button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/odontogram/partials/legend_modal.blade.php ENDPATH**/ ?>