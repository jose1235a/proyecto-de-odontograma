<?php $__env->startSection('title', __('dental_management.odontogram.title')); ?>

<?php $__env->startSection('content'); ?>
<?php
    $patient = $odontogram->patient;
?>
<?php echo $__env->make('dental_management.odontogram.partials.patient_conditions_alert', ['patient' => $patient], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-info rounded">
                <div class="card-header">
                    <h3 class="card-title"><?php echo e(__('dental_management.odontogram.patient_odontogram_title')); ?></h3>
                    <div class="card-tools">
                        <a href="<?php echo e($backUrl); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> <?php echo e(__('global.back')); ?>

                        </a>
                    </div>
                </div>

                <form action="<?php echo e(route('dental_management.odontogram.update', $odontogram)); ?>" method="POST" id="odontogram-form">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <?php if(!empty($returnUrl)): ?>
                        <input type="hidden" name="return_url" value="<?php echo e($returnUrl); ?>">
                    <?php endif; ?>
                    <input type="hidden" name="form_identifier" value="odontogram_edit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h3 class="card-title mb-0">
                                            <i class="fas fa-history"></i> <?php echo e(__('dental_management.odontogram.history_title')); ?>

                                        </h3>
                                        <span class="badge badge-secondary" id="history-count-badge"><?php echo e($histories->count()); ?></span>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive" style="max-height: 520px;">
                                            <table class="table table-sm table-hover mb-0" id="odontogram-history-table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th><?php echo e(__('dental_management.odontogram.history_registered')); ?></th>
                                                        <th><?php echo e(__('dental_management.odontogram.history_description')); ?></th>
                                                        <th><?php echo e(__('dental_management.odontogram.doctor')); ?></th>
                                                        <th class="text-center"><?php echo e(__('global.actions')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody data-empty-text="<?php echo e(__('global.no_records')); ?>">
                                                    <?php $__empty_1 = true; $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr class="<?php echo e(optional($activeHistory)->id === $history->id ? 'table-info' : ''); ?>"
                                                            data-history-row="<?php echo e($history->id); ?>">
                                                            <td data-column="registered"><?php echo e(optional($history->date_procedure ?? $history->created_at)->format('d/m/Y H:i')); ?></td>
                                                            <td data-column="description"><?php echo e(\Illuminate\Support\Str::limit($history->description, 40)); ?></td>
                                                            <td data-column="doctor"><?php echo e(trim(($history->doctor->name ?? '') . ' ' . ($history->doctor->last_name ?? '')) ?: '-'); ?></td>
                                                            <td class="text-center">
                                                                <div class="btn-group btn-group-sm">
                                                                    <button type="button"
                                                                            class="btn btn-outline-primary load-history"
                                                                            data-history='<?php echo json_encode($history->cumulative_canvas_data ?? $history->canvas_data, 15, 512) ?>'
                                                                            data-history-id="<?php echo e($history->id); ?>">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-outline-warning edit-history"
                                                                            data-update-url="<?php echo e(route('dental_management.odontogram_histories.update', $history)); ?>"
                                                                            data-history-id="<?php echo e($history->id); ?>"
                                                                            data-doctor-id="<?php echo e($history->doctor_id); ?>"
                                                                            data-description="<?php echo e(e($history->description)); ?>">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-outline-danger delete-history"
                                                                            data-delete-url="<?php echo e(route('dental_management.odontogram_histories.destroy', $history)); ?>"
                                                                            data-history-id="<?php echo e($history->id); ?>">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted"><?php echo e(__('global.no_records')); ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                        <input type="hidden" name="patient_id" value="<?php echo e($odontogram->patient_id); ?>">
                        <input type="hidden" name="is_active" value="1">

                        <?php
                            $formIdentifier = 'odontogram_edit';
                            $shouldPrefillForm = old('form_identifier') === $formIdentifier;
                            $editorSelectedDoctorId = $shouldPrefillForm ? old('doctor_id') : null;
                            $editorDescriptionValue = $shouldPrefillForm ? old('description') : '';
                        ?>

                        <?php echo $__env->make('dental_management.odontogram.partials.form_setup', [
                            'formIdentifier' => $formIdentifier,
                            'selectedDoctorId' => $editorSelectedDoctorId,
                            'descriptionValue' => $editorDescriptionValue,
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                        <?php echo $__env->make('dental_management.odontogram.partials.editor_workspace', [
                            'patient' => $patient ?? null,
                            'treatments' => $treatments,
                            'doctors' => $doctors,
                            'selectedDoctorId' => $editorSelectedDoctorId,
                            'descriptionValue' => $editorDescriptionValue,
                            'canvasWidth' => 750,
                            'canvasHeight' => 400,
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-success mr-4" id="update-odontogram-btn">
                            <i class="fas fa-save"></i> <?php echo e(__('global.update')); ?>

                        </button>
                        <a href="<?php echo e($backUrl); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> <?php echo e(__('global.cancel')); ?>

                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editHistoryModal" tabindex="-1" role="dialog" aria-labelledby="editHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHistoryModalLabel">
                    <i class="fas fa-edit"></i> <?php echo e(__('dental_management.odontogram.history_edit_title')); ?>

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo e(__('global.close')); ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-history-form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="edit-history-doctor"><?php echo e(__('dental_management.odontogram.history_edit_doctor')); ?></label>
                                <select name="doctor_id" id="edit-history-doctor" class="form-control select2 w-100">
                                    <option value=""><?php echo e(__('global.select_option')); ?></option>
                                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($doctor->id); ?>"><?php echo e($doctor->name); ?> <?php echo e($doctor->last_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="edit-history-description"><?php echo e(__('dental_management.odontogram.history_edit_description')); ?></label>
                                <textarea name="description" id="edit-history-description" class="form-control" rows="4" required maxlength="1000"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('global.cancel')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('global.save')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/select2/css/select2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/select2/css/select2-bootstrap4.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('adminlte/plugins/select2/js/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminlte/plugins/select2/js/i18n/es.js')); ?>"></script>
<?php echo $__env->make('dental_management.odontogram.partials.create_scripts', ['initialData' => $initialData, 'odontogram' => $odontogram], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('dental_management.odontogram.partials.history_scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/odontogram/edit.blade.php ENDPATH**/ ?>