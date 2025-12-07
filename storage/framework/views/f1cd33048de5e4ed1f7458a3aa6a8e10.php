<form id="form-save" action="<?php echo e(route('dental_management.consultations.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <?php if(isset($patient) && $patient): ?>
        <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
        <div class="form-group">
            <label><?php echo e(__('dental_management.consultations.fields.patient')); ?></label>
            <input type="text" class="form-control" value="<?php echo e($patient->name); ?> <?php echo e($patient->last_name); ?>" readonly>
        </div>
    <?php else: ?>
        <div class="form-group">
            <label for="patient_id"><?php echo e(__('dental_management.consultations.fields.patient')); ?> <span class="text-danger">*</span></label>
            <select name="patient_id" id="patient_id" class="form-control select2" required>
                <option value=""><?php echo e(__('global.select_option')); ?></option>
                <?php $__currentLoopData = \App\Models\Patient::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patientOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($patientOption->id); ?>" <?php echo e(old('patient_id') == $patientOption->id ? 'selected' : ''); ?>>
                        <?php echo e($patientOption->name); ?> <?php echo e($patientOption->last_name); ?> - <?php echo e($patientOption->document); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-danger mb-0"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="treatment_id"><?php echo e(__('dental_management.consultations.fields.treatment')); ?> <span class="text-danger">*</span></label>
                <select name="treatment_id" id="treatment_id" class="form-control select2" required>
                    <option value=""><?php echo e(__('global.select_option')); ?></option>
                    <?php $__currentLoopData = $treatments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($treatment->id); ?>" <?php echo e(old('treatment_id') == $treatment->id ? 'selected' : ''); ?>>
                            <?php echo e($treatment->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['treatment_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-danger mb-0"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="consultation_date"><?php echo e(__('dental_management.consultations.fields.consultation_date')); ?> <span class="text-danger">*</span></label>
                <input type="date" name="consultation_date" id="consultation_date" class="form-control"
                       value="<?php echo e(old('consultation_date', date('Y-m-d'))); ?>" required>
                <?php $__errorArgs = ['consultation_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="consultation_time"><?php echo e(__('dental_management.consultations.fields.consultation_time')); ?> <span class="text-danger">*</span></label>
                <input type="time" name="consultation_time" id="consultation_time" class="form-control"
                       value="<?php echo e(old('consultation_time', date('H:i'))); ?>" required>
                <?php $__errorArgs = ['consultation_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="fever"><?php echo e(__('dental_management.consultations.fields.fever')); ?></label>
                <div class="input-group">
                    <input type="number" name="fever" id="fever" class="form-control"
                           value="<?php echo e(old('fever')); ?>" step="0.1" min="30" max="45">
                    <div class="input-group-append">
                        <span class="input-group-text">°C</span>
                    </div>
                </div>
                <?php $__errorArgs = ['fever'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="blood_pressure"><?php echo e(__('dental_management.consultations.fields.blood_pressure')); ?></label>
                <input type="text" name="blood_pressure" id="blood_pressure" class="form-control"
                       value="<?php echo e(old('blood_pressure')); ?>" placeholder="120/80">
                <?php $__errorArgs = ['blood_pressure'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="doctor_id"><?php echo e(__('dental_management.consultations.fields.doctor')); ?> <span class="text-danger">*</span></label>
                <select name="doctor_id" id="doctor_id" class="form-control select2" required>
                    <option value=""><?php echo e(__('global.select_option')); ?></option>
                    <?php $__currentLoopData = $doctors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('doctor_id') == $doctor->id ? 'selected' : ''); ?>>
                            <?php echo e($doctor->name); ?> <?php echo e($doctor->last_name ?? ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-danger mb-0"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="description"><?php echo e(__('dental_management.consultations.fields.description')); ?> <span class="text-danger">*</span></label>
                <textarea name="description" id="description" class="form-control"
                          rows="2" maxlength="1000" required><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </div>
</form><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/consultations/partials/form_create.blade.php ENDPATH**/ ?>