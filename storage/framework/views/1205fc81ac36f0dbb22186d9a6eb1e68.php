<?php
    $existingPatient = optional(optional($appointment)->patient);
    $selectedTreatment = old('treatment_id', optional($appointment)->treatment_id);
    $selectedDoctor = old('doctor_id', optional($appointment)->doctor_id);
    $selectedStatus = old('status', optional($appointment)->status ?? 'scheduled');
    $isPatientLocked = isset($lockedPatient) && $lockedPatient;
    $lockedPatientId = $isPatientLocked ? $lockedPatient->id : null;
    $lockedPatientName = $isPatientLocked
        ? trim($lockedPatient->name . ' ' . ($lockedPatient->last_name ?? ''))
        : null;
    $selectedPatient = old('patient_id', $existingPatient->id ?? $lockedPatientId);
    $existingPatientName = $existingPatient->name
        ? trim($existingPatient->name . ' ' . ($existingPatient->last_name ?? ''))
        : '';
    $patientDocument = old('patient_document', $existingPatient->document);
    $patientName = old('patient_name', $existingPatientName ?: $lockedPatientName);
    $returnUrl = old('return_url', $returnUrl ?? request('return_url'));
?>

<form id="appointment-form" action="<?php echo e($formAction); ?>" method="POST" data-parsley-validate>
  <?php echo csrf_field(); ?>
  <?php if(in_array($method, ['PUT', 'PATCH'])): ?>
    <?php echo method_field($method); ?>
  <?php endif; ?>

  <input type="hidden" name="patient_id" id="hidden_patient_id" value="<?php echo e($selectedPatient); ?>">
  <input type="hidden" name="patient_name" id="patient_name" value="<?php echo e($patientName); ?>">
  <?php if(!empty($returnUrl)): ?>
    <input type="hidden" name="return_url" value="<?php echo e($returnUrl); ?>">
  <?php endif; ?>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="treatment_id"><?php echo e(__('dental_management.appointments.treatment')); ?> <span class="text-danger">*</span></label>
        <select name="treatment_id" id="treatment_id" class="form-control select2" required>
          <option value=""><?php echo e(__('global.select_option')); ?></option>
          <?php $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option
              value="<?php echo e($treatment->id); ?>"
              <?php echo e((string) $selectedTreatment === (string) $treatment->id ? 'selected' : ''); ?>

            >
              <?php echo e($treatment->name); ?> - S/ <?php echo e(number_format($treatment->cost, 2)); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['treatment_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <small class="text-danger"><?php echo e($message); ?></small>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="doctor_id"><?php echo e(__('dental_management.appointments.doctor')); ?> <span class="text-danger">*</span></label>
        <select name="doctor_id" id="doctor_id" class="form-control select2" required>
          <option value=""><?php echo e(__('global.select_option')); ?></option>
          <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php ($doctorName = trim($doctor->name . ' ' . ($doctor->last_name ?? ''))); ?>
            <option value="<?php echo e($doctor->id); ?>" <?php echo e((string) $selectedDoctor === (string) $doctor->id ? 'selected' : ''); ?>>
              <?php echo e($doctorName); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <small class="text-danger"><?php echo e($message); ?></small>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="patient_select"><?php echo e(__('dental_management.appointments.patient')); ?> <span class="text-danger">*</span></label>
        <select name="patient_id" id="patient_select" class="form-control select2" <?php echo e($isPatientLocked ? 'disabled' : ''); ?> required>
          <?php if(!$isPatientLocked): ?>
            <option value=""><?php echo e(__('global.select_option')); ?></option>
            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php ($patientName = trim($patient->name . ' ' . ($patient->last_name ?? ''))); ?>
              <option value="<?php echo e($patient->id); ?>" <?php echo e((string) $selectedPatient === (string) $patient->id ? 'selected' : ''); ?>>
                <?php echo e($patientName); ?> - <?php echo e($patient->document); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
            <option value="<?php echo e($lockedPatientId); ?>" selected>
              <?php echo e($lockedPatientName); ?> - <?php echo e($lockedPatient->document); ?>

            </option>
          <?php endif; ?>
        </select>
        <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <small class="text-danger"><?php echo e($message); ?></small>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="appointment_date"><?php echo e(__('dental_management.appointments.date')); ?> <span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="appointment_date" name="appointment_date"
               value="<?php echo e(old('appointment_date', optional(optional($appointment)->appointment_date)->format('Y-m-d'))); ?>" required>
        <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <small class="text-danger"><?php echo e($message); ?></small>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="appointment_time"><?php echo e(__('dental_management.appointments.time')); ?> <span class="text-danger">*</span></label>
        <input type="time" class="form-control" id="appointment_time" name="appointment_time"
               value="<?php echo e(old('appointment_time', optional(optional($appointment)->appointment_time)->format('H:i'))); ?>" required>
        <?php $__errorArgs = ['appointment_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <small class="text-danger"><?php echo e($message); ?></small>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="notes"><?php echo e(__('dental_management.appointments.notes')); ?></label>
        <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo e(old('notes', optional($appointment)->notes ?? '')); ?></textarea>
      </div>
    </div>
    <?php if(in_array($method, ['PUT', 'PATCH'])): ?>
      <div class="col-md-6">
        <div class="form-group">
          <label for="status"><?php echo e(__('dental_management.appointments.status')); ?> <span class="text-danger">*</span></label>
          <select name="status" id="status" class="form-control" required>
            <option value="">Seleccione una opción</option>
            <option value="scheduled" <?php echo e(old('status', optional($appointment)->status) == 'scheduled' ? 'selected' : ''); ?>>Asignado</option>
            <option value="completed" <?php echo e(old('status', optional($appointment)->status) == 'completed' ? 'selected' : ''); ?>>Atendido</option>
            <option value="cancelled" <?php echo e(old('status', optional($appointment)->status) == 'cancelled' ? 'selected' : ''); ?>>Cancelado</option>
          </select>
          <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <small class="text-danger"><?php echo e($message); ?></small>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</form>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/appointments/partials/form_fields.blade.php ENDPATH**/ ?>