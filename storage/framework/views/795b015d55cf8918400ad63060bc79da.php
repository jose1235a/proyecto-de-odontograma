<?php
    $odontograms ??= collect();
    $showPatientColumn = $showPatientColumn ?? false;
    $showViewAction = $showViewAction ?? true;
    $enableDataTable = $enableDataTable ?? false;
    $returnUrl = $returnUrl ?? null;
?>

<div class="table-responsive">
    <table class="table table-bordered table-striped" <?php if($enableDataTable): ?> data-odontogram-list <?php endif; ?>>
        <thead>
            <tr>
                <?php if($showPatientColumn): ?>
                    <th><?php echo e(__('dental_management.odontogram.patient')); ?></th>
                <?php endif; ?>
                <th><?php echo e(__('dental_management.odontogram.history_description')); ?></th>
                <th><?php echo e(__('dental_management.odontogram.doctor')); ?></th>
                <th><?php echo e(__('dental_management.odontogram.history_registered')); ?></th>
                <th><?php echo e(__('global.actions')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $odontograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $odontogram): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $latestHistory = $odontogram->latestHistory;
                    $registeredAt = optional(optional($latestHistory)->date_procedure ?? $odontogram->created_at)->format('d/m/Y H:i') ?? '-';
                    $doctorName = optional($latestHistory?->doctor)->name ?? '-';
                    $encodedReturn = $returnUrl ? '?return_url=' . urlencode($returnUrl) : '';
                ?>
                <tr>
                    <?php if($showPatientColumn): ?>
                        <td><?php echo e(trim(($odontogram->patient->name ?? '-') . ' ' . ($odontogram->patient->last_name ?? ''))); ?></td>
                    <?php endif; ?>
                    <td><?php echo e(\Illuminate\Support\Str::limit(optional($latestHistory)->description, 50) ?? '-'); ?></td>
                    <td><?php echo e($doctorName); ?></td>
                    <td><?php echo e($registeredAt); ?></td>
                    <td>
                        <div class="btn-group">
                            <?php if($showViewAction): ?>
                                <a href="<?php echo e(route('dental_management.odontogram.show', $odontogram)); ?>"
                                   class="btn btn-info btn-sm" title="<?php echo e(__('global.show')); ?>">
                                    <i class="fas fa-eye"></i>
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('dental_management.odontogram.edit', $odontogram) . $encodedReturn); ?>"
                               class="btn btn-warning btn-sm" title="<?php echo e(__('global.edit')); ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="<?php echo e($showPatientColumn ? 5 : 4); ?>" class="text-center"><?php echo e(__('global.no_records')); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/odontogram/partials/odontogram_table.blade.php ENDPATH**/ ?>