<div class="row mt-4">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> <?php echo e(__('global.record_audit')); ?>

                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php echo $__env->make('dental_management.patients.partials.form_show_audit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/partials/audit_card.blade.php ENDPATH**/ ?>