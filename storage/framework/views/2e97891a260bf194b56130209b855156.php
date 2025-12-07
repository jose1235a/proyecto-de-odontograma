<form id="form-save" action="<?php echo e(route('dental_management.payments.store')); ?>" method="POST" data-parsley-validate>
  <?php echo csrf_field(); ?>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="patient_id"><?php echo e(__('dental_management.payments.fields.patient')); ?> <span class="text-danger">(*)</span></label>
        <?php if(isset($patient) && $patient): ?>
          <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
          <input type="text" class="form-control" value="<?php echo e($patient->name); ?> <?php echo e($patient->last_name); ?>" readonly>
        <?php else: ?>
          <select name="patient_id" id="patient_id" class="form-control select2" required>
            <option value=""><?php echo e(__('global.select_option')); ?></option>
            <?php $__currentLoopData = \App\Models\Patient::notDeleted()->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patientOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($patientOption->id); ?>" <?php echo e(old('patient_id') == $patientOption->id ? 'selected' : ''); ?>>
                <?php echo e($patientOption->name); ?> <?php echo e($patientOption->last_name); ?> - <?php echo e($patientOption->document); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        <?php endif; ?>
        <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="appointment_id"><?php echo e(__('dental_management.payments.fields.appointment')); ?></label>
        <select name="appointment_id" id="appointment_id" class="form-control select2">
          <option value="">Seleccionar cita</option>
          <?php if(isset($appointments) && $appointments->count() > 0): ?>
            <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($appointment->id); ?>" <?php echo e(old('appointment_id') == $appointment->id ? 'selected' : ''); ?>>
                <?php echo e($appointment->appointment_date->format('d/m/Y')); ?> <?php echo e($appointment->appointment_time ? $appointment->appointment_time->format('H:i') : 'N/A'); ?> - <?php echo e($appointment->treatment->name ?? 'Sin tratamiento'); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </select>
        <?php $__errorArgs = ['appointment_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
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
        <label for="amount"><?php echo e(__('dental_management.payments.fields.amount')); ?> <span class="text-danger">(*)</span></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">S/</span>
          </div>
          <input type="number" name="amount" id="amount" class="form-control"
                 value="<?php echo e(old('amount')); ?>" step="0.01" min="0.01" max="999999.99" required>
        </div>
        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="payment_date"><?php echo e(__('dental_management.payments.fields.payment_date')); ?> <span class="text-danger">(*)</span></label>
        <input type="date" name="payment_date" id="payment_date" class="form-control"
               value="<?php echo e(old('payment_date', date('Y-m-d'))); ?>" required>
        <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
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
        <label for="payment_method"><?php echo e(__('dental_management.payments.fields.payment_method')); ?> <span class="text-danger">(*)</span></label>
        <select name="payment_method" id="payment_method" class="form-control" required>
          <option value="cash" <?php echo e(old('payment_method') == 'cash' ? 'selected' : ''); ?>><?php echo e(__('dental_management.payments.methods.cash')); ?></option>
          <option value="card" <?php echo e(old('payment_method') == 'card' ? 'selected' : ''); ?>><?php echo e(__('dental_management.payments.methods.card')); ?></option>
          <option value="transfer" <?php echo e(old('payment_method') == 'transfer' ? 'selected' : ''); ?>><?php echo e(__('dental_management.payments.methods.transfer')); ?></option>
          <option value="check" <?php echo e(old('payment_method') == 'check' ? 'selected' : ''); ?>><?php echo e(__('dental_management.payments.methods.check')); ?></option>
        </select>
        <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="status"><?php echo e(__('dental_management.payments.fields.status')); ?> <span class="text-danger">(*)</span></label>
        <select name="status" id="status" class="form-control" required>
          <option value="pending" <?php echo e(old('status', 'pending') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('dental_management.payments.status_values.pending')); ?></option>
          <option value="completed" <?php echo e(old('status') == 'completed' ? 'selected' : ''); ?>><?php echo e(__('dental_management.payments.status_values.completed')); ?></option>
          <option value="cancelled" <?php echo e(old('status') == 'cancelled' ? 'selected' : ''); ?>><?php echo e(__('dental_management.payments.status_values.cancelled')); ?></option>
          <option value="refunded" <?php echo e(old('status') == 'refunded' ? 'selected' : ''); ?>><?php echo e(__('dental_management.payments.status_values.refunded')); ?></option>
        </select>
        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="reference_number"><?php echo e(__('dental_management.payments.fields.reference_number')); ?></label>
    <input type="text" name="reference_number" id="reference_number" class="form-control"
           value="<?php echo e(old('reference_number')); ?>" maxlength="50">
    <?php $__errorArgs = ['reference_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
  </div>

  <div class="form-group">
    <label for="notes"><?php echo e(__('dental_management.payments.fields.notes')); ?></label>
    <textarea name="notes" id="notes" class="form-control" rows="3" maxlength="500"><?php echo e(old('notes')); ?></textarea>
    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
  </div>
</form><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/payments/partials/form_create.blade.php ENDPATH**/ ?>