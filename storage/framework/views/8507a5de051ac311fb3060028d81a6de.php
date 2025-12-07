<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('system_management.regions.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('regions.id')); ?>

        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('system_management.regions.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('regions.name')); ?>

        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('system_management.regions.index', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('regions.is_active')); ?>

        </a>
      </th>
      <th><?php echo e(__('global.actions')); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($loop->iteration + $regions->firstItem() - 1); ?></td>
        <td><?php echo e($region->name); ?></td>
        <td><?php echo $region->state_html; ?></td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="<?php echo e(route('system_management.regions.show', $region)); ?>" title="<?php echo e(__('global.show')); ?>">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="<?php echo e(route('system_management.regions.edit', $region)); ?>" title="<?php echo e(__('global.edit')); ?>">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="<?php echo e(route('system_management.regions.delete', $region)); ?>" title="<?php echo e(__('global.delete')); ?>">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  <?php echo e($regions->links()); ?>

</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/system_management/regions/partials/index_results.blade.php ENDPATH**/ ?>