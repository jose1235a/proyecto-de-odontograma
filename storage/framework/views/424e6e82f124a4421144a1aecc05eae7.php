<?php
    $odontograms = $patient->odontograms;
?>

<?php echo $__env->make('dental_management.odontogram.partials.odontogram_table', [
    'odontograms' => $odontograms,
    'showPatientColumn' => false,
    'showViewAction' => false,
    'enableDataTable' => false,
    'returnUrl' => route('dental_management.patients.show', $patient) . '?tab=odontograms',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="row mt-4">
    <div class="col-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i> <?php echo e(__('dental_management.odontogram.treatment_history_title')); ?>

                </h3>
                <div class="card-tools">
                    <?php echo e(__('global.card_title_result')); ?>: <span class="badge badge-light" id="treatment-history-count"><?php echo e(count($treatmentHistory)); ?></span>
                </div>
            </div>
            <div class="card-body">
                <?php if(count($treatmentHistory) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" data-odontogram-list>
                            <thead>
                                <tr>
                                    <th><?php echo e(__('dental_management.odontogram.history_registered')); ?></th>
                                    <th><?php echo e(__('dental_management.odontogram.history_description')); ?></th>
                                    <th><?php echo e(__('dental_management.odontogram.doctor')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $treatmentHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-order="<?php echo e($history['registered_timestamp'] ?? 0); ?>">
                                            <?php echo e($history['registered_at'] ?? '-'); ?>

                                        </td>
                                        <td><?php echo e($history['description']); ?></td>
                                        <td><?php echo e($history['doctor'] ? $history['doctor']['name'] . ' ' . $history['doctor']['last_name'] : '-'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted"><?php echo e(__('global.no_records')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('dental_management.patients.partials.audit_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/partials/tabs/odontograms.blade.php ENDPATH**/ ?>