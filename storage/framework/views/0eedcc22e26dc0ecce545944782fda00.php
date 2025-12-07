<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="patient"><?php echo e(__('dental_management.appointments.patient')); ?></label>
      <input
        type="text"
        class="form-control"
        id="patient"
        name="patient"
        value="<?php echo e(request('patient')); ?>"
        placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.appointments.patient')])); ?>"
      >
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="treatment_id"><?php echo e(__('dental_management.appointments.treatment')); ?></label>
      <select class="form-control" id="treatment_id" name="treatment_id">
        <option value=""><?php echo e(__('global.all')); ?></option>
        <?php $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($treatment->id); ?>" <?php echo e((string) request('treatment_id') === (string) $treatment->id ? 'selected' : ''); ?>>
            <?php echo e($treatment->name); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="doctor_id"><?php echo e(__('dental_management.appointments.doctor')); ?></label>
      <select class="form-control" id="doctor_id" name="doctor_id">
        <option value=""><?php echo e(__('global.all')); ?></option>
        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php ($doctorName = trim($doctor->name . ' ' . ($doctor->last_name ?? ''))); ?>
          <option value="<?php echo e($doctor->id); ?>" <?php echo e((string) request('doctor_id') === (string) $doctor->id ? 'selected' : ''); ?>>
            <?php echo e($doctorName); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="status"><?php echo e(__('dental_management.appointments.status')); ?></label>
      <select class="form-control" id="status" name="status">
        <option value=""><?php echo e(__('global.all')); ?></option>
        <option value="scheduled" <?php echo e(request('status') === 'scheduled' ? 'selected' : ''); ?>>
          <?php echo e(__('dental_management.appointments.status_assigned')); ?>

        </option>
        <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>
          <?php echo e(__('dental_management.appointments.status_attended')); ?>

        </option>
        <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>
          <?php echo e(__('dental_management.appointments.status_cancelled')); ?>

        </option>
      </select>
    </div>
  </div>
</div>

<div class="row">
  <!-- Removed date filter per request -->
</div>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/appointments/partials/index_filters.blade.php ENDPATH**/ ?>