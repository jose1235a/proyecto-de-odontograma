<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('dental_management.patients.edit_all', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('dental_management.patients.id')); ?>

        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('dental_management.patients.edit_all', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('dental_management.patients.name')); ?>

        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('dental_management.patients.edit_all', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('dental_management.patients.last_name')); ?>

        </a>
      </th>
      <th><?php echo e(__('dental_management.patients.email')); ?></th>
      <th><?php echo e(__('dental_management.patients.phone')); ?></th>
      <th><?php echo e(__('dental_management.patients.document')); ?></th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e(route('dental_management.patients.edit_all', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']))); ?>">
          <?php echo e(__('dental_management.patients.is_active')); ?>

        </a>
      </th>
      <th><?php echo e(__('global.actions')); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($patient->id); ?></td>

        <!-- Editable name field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="<?php echo e($patient->id); ?>"
            data-field="name"
            data-original="<?php echo e($patient->name); ?>">
          <?php echo e($patient->name); ?>

        </td>

        <!-- Editable last_name field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="<?php echo e($patient->id); ?>"
            data-field="last_name"
            data-original="<?php echo e($patient->last_name); ?>">
          <?php echo e($patient->last_name ?? '-'); ?>

        </td>

        <!-- Editable email field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="<?php echo e($patient->id); ?>"
            data-field="email"
            data-original="<?php echo e($patient->email); ?>">
          <?php echo e($patient->email); ?>

        </td>

        <!-- Editable phone field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="<?php echo e($patient->id); ?>"
            data-field="phone"
            data-original="<?php echo e($patient->phone); ?>">
          <?php echo e($patient->phone ?? '-'); ?>

        </td>

        <!-- Editable document field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="<?php echo e($patient->id); ?>"
            data-field="document"
            data-original="<?php echo e($patient->document); ?>">
          <?php echo e($patient->document ?? '-'); ?>

        </td>

        <!-- Editable status field -->
        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="<?php echo e($patient->id); ?>"
                  data-field="is_active"
                  data-original="<?php echo e($patient->is_active); ?>">
            <option value="1" <?php echo e($patient->is_active ? 'selected' : ''); ?>><?php echo e(__('global.active')); ?></option>
            <option value="0" <?php echo e(!$patient->is_active ? 'selected' : ''); ?>><?php echo e(__('global.inactive')); ?></option>
          </select>
        </td>

        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="<?php echo e(route('dental_management.patients.show', $patient)); ?>" title="<?php echo e(__('global.show')); ?>">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.patients.edit', $patient)); ?>" title="<?php echo e(__('global.edit')); ?>">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.patients.delete', $patient)); ?>" title="<?php echo e(__('global.delete')); ?>">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  <?php echo e($patients->links()); ?>

</div><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/partials/edit_all_results.blade.php ENDPATH**/ ?>