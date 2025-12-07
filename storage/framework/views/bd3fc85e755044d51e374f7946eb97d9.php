<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="payment_date"><?php echo e(__('dental_management.payments.payment_date')); ?></label>
            <input type="date" class="form-control" id="payment_date" name="payment_date"
                   value="<?php echo e(request('payment_date')); ?>">
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="status"><?php echo e(__('dental_management.payments.fields.status')); ?></label>
            <select class="form-control" id="status" name="status">
                <option value=""><?php echo e(__('global.all')); ?></option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>
                    <?php echo e(__('dental_management.payments.status.pending')); ?>

                </option>
                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>
                    <?php echo e(__('dental_management.payments.status.completed')); ?>

                </option>
                <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>
                    <?php echo e(__('dental_management.payments.status.cancelled')); ?>

                </option>
                <option value="refunded" <?php echo e(request('status') == 'refunded' ? 'selected' : ''); ?>>
                    <?php echo e(__('dental_management.payments.status.refunded')); ?>

                </option>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="payment_method"><?php echo e(__('dental_management.payments.fields.payment_method')); ?></label>
            <select class="form-control" id="payment_method" name="payment_method">
                <option value=""><?php echo e(__('global.all')); ?></option>
                <option value="cash" <?php echo e(request('payment_method') == 'cash' ? 'selected' : ''); ?>>
                    <?php echo e(__('dental_management.payments.methods.cash')); ?>

                </option>
                <option value="card" <?php echo e(request('payment_method') == 'card' ? 'selected' : ''); ?>>
                    <?php echo e(__('dental_management.payments.methods.card')); ?>

                </option>
                <option value="transfer" <?php echo e(request('payment_method') == 'transfer' ? 'selected' : ''); ?>>
                    <?php echo e(__('dental_management.payments.methods.transfer')); ?>

                </option>
                <option value="check" <?php echo e(request('payment_method') == 'check' ? 'selected' : ''); ?>>
                    <?php echo e(__('dental_management.payments.methods.check')); ?>

                </option>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="patient_id"><?php echo e(__('dental_management.payments.patient')); ?></label>
            <select class="form-control select2" id="patient_id" name="patient_id">
                <option value=""><?php echo e(__('global.all')); ?></option>
                <?php $__currentLoopData = \App\Models\Patient::active()->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($patient->id); ?>" <?php echo e(request('patient_id') == $patient->id ? 'selected' : ''); ?>>
                        <?php echo e($patient->name); ?> <?php echo e($patient->last_name); ?> - <?php echo e($patient->document); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="amount_min"><?php echo e(__('dental_management.payments.amount')); ?> Min/Max</label>
            <div class="input-group">
                <input type="number" class="form-control" id="amount_min" name="amount_min"
                       placeholder="Min" value="<?php echo e(request('amount_min')); ?>" step="0.01">
                <input type="number" class="form-control" id="amount_max" name="amount_max"
                       placeholder="Max" value="<?php echo e(request('amount_max')); ?>" step="0.01">
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/payments/partials/index_filters.blade.php ENDPATH**/ ?>