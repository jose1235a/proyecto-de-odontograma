<?php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'desc');
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
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('appointment_date', 'desc')); ?>"><?php echo e(__('dental_management.appointments.appointment_date')); ?></a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('treatment')); ?>"><?php echo e(__('dental_management.appointments.treatment')); ?></a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('doctor')); ?>"><?php echo e(__('dental_management.appointments.doctor')); ?></a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('patient')); ?>"><?php echo e(__('dental_management.appointments.patient')); ?></a>
      </th>
      <th class="text-center">
        <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('status')); ?>"><?php echo e(__('global.status')); ?></a>
      </th>
      <th class="text-center"><?php echo e(__('global.actions')); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr>
        <td><?php echo e($loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage()); ?></td>
        <td>
          <?php if($appointment->appointment_date && $appointment->appointment_time): ?>
            <?php echo e($appointment->appointment_date->format('d/m/Y')); ?> <?php echo e($appointment->appointment_time->format('H:i')); ?>

          <?php else: ?>
            -
          <?php endif; ?>
        </td>
        <td><?php echo e($appointment->treatment->name ?? '-'); ?></td>
        <?php ($doctorName = $appointment->doctor ? trim($appointment->doctor->name . ' ' . ($appointment->doctor->last_name ?? '')) : '-'); ?>
        <?php ($patientName = $appointment->patient ? trim($appointment->patient->name . ' ' . ($appointment->patient->last_name ?? '')) : '-'); ?>
        <td><?php echo e($doctorName); ?></td>
        <td><?php echo e($patientName); ?></td>
        <td class="text-center"><?php echo $appointment->status_html; ?></td>
        <td class="text-center">
          <div class="btn-group btn-group-sm" role="group">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('appointments.view')): ?>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.appointments.show', $appointment)); ?>" title="<?php echo e(__('global.show')); ?>">
              <i class="fas fa-eye"></i>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('appointments.edit')): ?>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.appointments.edit', $appointment)); ?>" title="<?php echo e(__('global.edit')); ?>">
              <i class="fas fa-pen"></i>
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('appointments.delete')): ?>
            <a class="btn btn-light" href="<?php echo e(route('dental_management.appointments.delete', $appointment)); ?>" title="<?php echo e(__('global.delete')); ?>">
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

<?php if($appointments->hasPages()): ?>
  <div class="d-flex justify-content-center mt-3">
    <?php echo e($appointments->appends(request()->query())->links()); ?>

  </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/appointments/partials/index_results.blade.php ENDPATH**/ ?>