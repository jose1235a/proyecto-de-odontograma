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
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('name')); ?>"><?php echo e(__('dental_management.treatments.name')); ?></a>
      </th>
      <th class="text-right">
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('cost')); ?>"><?php echo e(__('dental_management.treatments.cost')); ?></a>
      </th>
      <th class="text-center">
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('is_active')); ?>"><?php echo e(__('dental_management.treatments.is_active')); ?></a>
      </th>
      <th class="text-center"><?php echo e(__('global.actions')); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr>
        <td><?php echo e($loop->iteration + ($treatments->currentPage() - 1) * $treatments->perPage()); ?></td>
        <td>
          <strong><?php echo e($treatment->name); ?></strong>
          <?php
              $coverageKey = $treatment->coverage === 'full' ? 'coverage_full' : 'coverage_partial';
              $coverageClass = $treatment->coverage === 'full' ? 'badge-info' : 'badge-secondary';
          ?>
          <div class="mt-1">
            <span class="badge <?php echo e($coverageClass); ?>"><?php echo e(__('dental_management.treatments.' . $coverageKey)); ?></span>
          </div>
          <?php if($treatment->description): ?>
            <div class="text-muted small mt-1"><?php echo e(Str::limit($treatment->description, 80)); ?></div>
          <?php endif; ?>
        </td>
        <td class="text-right"><?php echo e($treatment->getCostFormattedAttribute()); ?></td>
        <td class="text-center"><?php echo $treatment->getStateHtmlAttribute(); ?></td>
        <td class="text-center">
          <div class="btn-group btn-group-sm" role="group">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('treatments.view')): ?>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.treatments.show', $treatment)); ?>" title="<?php echo e(__('global.show')); ?>">
              <i class="fas fa-eye"></i>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('treatments.edit')): ?>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.treatments.edit', $treatment)); ?>" title="<?php echo e(__('global.edit')); ?>">
              <i class="fas fa-pen"></i>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('treatments.delete')): ?>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.treatments.delete', $treatment)); ?>" title="<?php echo e(__('global.delete')); ?>">
              <i class="fas fa-trash"></i>
            </a>
            <?php endif; ?>
          </div>
        </td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
        <td colspan="5" class="text-center">
          <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle"></i> <?php echo e(__('global.no_records_found')); ?>

          </div>
        </td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<?php if($treatments->hasPages()): ?>
  <div class="d-flex justify-content-center mt-3">
    <?php echo e($treatments->appends(request()->query())->links()); ?>

  </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/treatments/partials/index_results.blade.php ENDPATH**/ ?>