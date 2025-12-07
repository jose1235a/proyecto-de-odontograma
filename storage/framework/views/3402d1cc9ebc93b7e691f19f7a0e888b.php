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
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('id')); ?>">N°</a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('document')); ?>"><?php echo e(__('dental_management.patients.document')); ?></a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('name')); ?>"><?php echo e(__('dental_management.patients.name')); ?></a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('age')); ?>"><?php echo e(__('dental_management.patients.age')); ?></a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('allergy')); ?>"><?php echo e(__('dental_management.patients.allergy')); ?></a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('status')); ?>"><?php echo e(__('global.status')); ?></a>
      </th>
      <th><?php echo e(__('global.actions')); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr>
        <td><?php echo e($loop->iteration + ($patients->currentPage() - 1) * $patients->perPage()); ?></td>
        <td><?php echo e($patient->document ?? '-'); ?></td>
        <td><?php echo e($patient->full_name); ?></td>
        <td><?php echo e($patient->age ?? '-'); ?></td>
        <td><?php echo e($patient->allergy); ?></td>
        <td><?php echo $patient->state_html; ?></td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.view')): ?>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.patients.show', $patient)); ?>" title="<?php echo e(__('global.show')); ?>">
              <i class="fas fa-eye"></i>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.edit')): ?>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.patients.edit', $patient)); ?>" title="<?php echo e(__('global.edit')); ?>">
              <i class="fas fa-pen"></i>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.delete')): ?>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.patients.delete', $patient)); ?>" title="<?php echo e(__('global.delete')); ?>">
              <i class="fas fa-trash"></i>
            </a>
            <?php endif; ?>
          </div>
        </td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
        <td colspan="7" class="text-center"><?php echo e(__('global.no_records')); ?></td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  <?php echo e($patients->appends(request()->query())->links()); ?>

</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/partials/index_results.blade.php ENDPATH**/ ?>