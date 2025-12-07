<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('system_management.languages.index', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('languages.id')); ?>

        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('system_management.languages.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('languages.name')); ?>

        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('system_management.languages.index', array_merge(request()->all(), ['sort' => 'iso_code', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('languages.iso_code')); ?>

        </a>
      </th>      
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('system_management.languages.index', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('languages.is_active')); ?>

        </a>
      </th>
      <th><?php echo e(__('global.actions')); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($loop->iteration + $languages->firstItem() - 1); ?></td>
        <td><?php echo e($language->name); ?></td>
        <td><?php echo e($language->iso_code); ?></td>
        <td><?php echo $language->state_html; ?></td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="<?php echo e(route('system_management.languages.show', $language)); ?>" title="<?php echo e(__('global.show')); ?>">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="<?php echo e(route('system_management.languages.edit', $language)); ?>" title="<?php echo e(__('global.edit')); ?>">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="<?php echo e(route('system_management.languages.delete', $language)); ?>" title="<?php echo e(__('global.delete')); ?>">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  <?php echo e($languages->links()); ?>

</div><?php /**PATH C:\laragon\www\blog_main_base\resources\views/system_management/languages/partials/index_results.blade.php ENDPATH**/ ?>