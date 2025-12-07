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

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>
                    <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('id')); ?>">N°</a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('document')); ?>"><?php echo e(__('dental_management.doctors.document')); ?></a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('name')); ?>"><?php echo e(__('dental_management.doctors.name')); ?></a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('specialty')); ?>"><?php echo e(__('dental_management.doctors.specialty')); ?></a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('address')); ?>"><?php echo e(__('dental_management.doctors.address')); ?></a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('email')); ?>"><?php echo e(__('dental_management.doctors.email')); ?></a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('phone')); ?>"><?php echo e(__('dental_management.doctors.phone')); ?></a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('status')); ?>"><?php echo e(__('global.status')); ?></a>
                </th>
                <th><?php echo e(__('global.actions')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->iteration + ($doctors->currentPage() - 1) * $doctors->perPage()); ?></td>
                    <td><?php echo e($doctor->document_type); ?> <?php echo e($doctor->document); ?></td>
                    <td><?php echo e($doctor->full_name); ?></td>
                    <td>
                        <?php $__empty_2 = true; $__currentLoopData = $doctor->specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <span class="badge badge-primary"><?php echo e($specialty->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?php echo e(Str::limit($doctor->address, 30) ?? '-'); ?></td>
                    <td><?php echo e($doctor->email); ?></td>
                    <td><?php echo e($doctor->phone ?? '-'); ?></td>
                    <td><?php echo $doctor->state_html; ?></td>
                    <td>
                      <div class="btn-group btn-group-sm" role="group">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('doctors.view')): ?>
                        <a class="btn btn-light" href="<?php echo e(route('dental_management.doctors.show', $doctor)); ?>" title="<?php echo e(__('global.show')); ?>">
                          <i class="fas fa-eye"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('doctors.edit')): ?>
                        <a class="btn btn-light" href="<?php echo e(route('dental_management.doctors.edit', $doctor)); ?>" title="<?php echo e(__('global.edit')); ?>">
                          <i class="fas fa-pen"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('doctors.delete')): ?>
                        <a class="btn btn-light" href="<?php echo e(route('dental_management.doctors.delete', $doctor)); ?>" title="<?php echo e(__('global.delete')); ?>">
                          <i class="fas fa-trash"></i>
                        </a>
                        <?php endif; ?>
                      </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="text-center"><?php echo e(__('global.no_records')); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($doctors->hasPages()): ?>
    <div class="d-flex justify-content-center">
        <?php echo e($doctors->appends(request()->query())->links()); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/doctors/partials/index_results.blade.php ENDPATH**/ ?>