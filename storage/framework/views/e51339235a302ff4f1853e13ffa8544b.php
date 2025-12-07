<?php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'asc');
    $sortUrl = function (string $column, string $defaultDirection = 'asc') use ($currentSort, $currentDirection) {
        $direction = $currentSort === $column
            ? ($currentDirection === 'asc' ? 'desc' : 'asc')
            : $defaultDirection;
        return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $direction, 'page' => 1]);
    };
?>

<table class="table table-hover">
    <thead class="bg-light">
        <tr>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('id')); ?>">
                    <?php echo e(__('dental_management.specialties.id')); ?>

                </a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('name')); ?>">
                    <?php echo e(__('dental_management.specialties.name')); ?>

                </a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('is_active')); ?>">
                    <?php echo e(__('global.status')); ?>

                </a>
            </th>
            <th><?php echo e(__('global.actions')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration + $specialties->firstItem() - 1); ?></td>
                <td><?php echo e($specialty->name); ?></td>
                <td><?php echo $specialty->state_html; ?></td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-light" href="<?php echo e(route('dental_management.specialties.show', $specialty)); ?>" title="<?php echo e(__('global.show')); ?>">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a class="btn btn-light" href="<?php echo e(route('dental_management.specialties.edit', $specialty)); ?>" title="<?php echo e(__('global.edit')); ?>">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a class="btn btn-light" href="<?php echo e(route('dental_management.specialties.delete', $specialty)); ?>" title="<?php echo e(__('global.delete')); ?>">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="4" class="text-center"><?php echo e(__('global.no_records')); ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    <?php echo e($specialties->appends(request()->query())->links()); ?>

</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/specialties/partials/index_results.blade.php ENDPATH**/ ?>