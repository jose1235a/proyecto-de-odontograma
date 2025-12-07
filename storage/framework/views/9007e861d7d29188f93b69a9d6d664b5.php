<?php if (! $__env->hasRenderedOnce('edde5c57-d938-4bce-ac4e-06f1090a1fe3')): $__env->markAsRenderedOnce('edde5c57-d938-4bce-ac4e-06f1090a1fe3'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('adminlte/css/odontogram.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/select2/css/select2.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php
    $patient ??= null;
    $treatments ??= collect();
    $doctors ??= collect();
    $showPatientInfo = $showPatientInfo ?? true;
    $showControls = $showControls ?? true;
    $showDoctorFields = $showDoctorFields ?? $showControls;
    $showLegendButton = $showLegendButton ?? true;
    $showLegendModal = $showLegendModal ?? true;
    $showAdvancedOptions = $showAdvancedOptions ?? $showControls;
    $doctorFieldRequired = $doctorFieldRequired ?? false;
    $descriptionRequired = $descriptionRequired ?? false;
    $selectedDoctorId = $selectedDoctorId ?? null;
    $descriptionValue = $descriptionValue ?? '';
    $canvasWidth = $canvasWidth ?? 1024;
    $canvasHeight = $canvasHeight ?? 500;
    $canvasStyle = $canvasStyle ?? '';
    $canvasHint = $canvasHint ?? __('dental_management.odontogram.click_instruction');
    $showSaveActionButton = $showSaveActionButton ?? true;
?>

<?php if($showPatientInfo): ?>
    <?php echo $__env->make('dental_management.odontogram.partials.patient_info', ['patient' => $patient], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo e(__('dental_management.odontogram.odontogram_editor')); ?></h3>
                <div class="card-tools">
                    <?php if($showLegendButton): ?>
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#odontogram-legend-modal">
                            <i class="fas fa-info-circle"></i> <?php echo e(__('dental_management.odontogram.legend')); ?>

                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <canvas
                        id="odontogram-canvas"
                        class="odontogram-canvas"
                        width="<?php echo e($canvasWidth); ?>"
                        height="<?php echo e($canvasHeight); ?>"
                        <?php if($canvasStyle): ?> style="<?php echo e($canvasStyle); ?>" <?php endif; ?>
                    ></canvas>
                    <?php if(!empty($canvasHint)): ?>
                        <div class="mt-2">
                            <small class="text-info"><?php echo e($canvasHint); ?></small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($showControls): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-lg-4 mb-3 mb-lg-0">
                            <div class="text-center">
                                <div class="mb-2">
                                    <strong><?php echo e(__('dental_management.odontogram.selected_tooth_title')); ?></strong>
                                </div>
                                <div class="odontogram-selected-tooth">
                                    <canvas id="selected-tooth-canvas" width="180" height="180" style="cursor: pointer;"></canvas>
                                </div>
                                <div class="mt-3 text-center">
                                    <div class="font-weight-bold">
                                        <?php echo e(__('dental_management.odontogram.selected_tooth_label')); ?>:
                                        <span id="summary-current-tooth">-</span>
                                    </div>
                                    <div class="text-muted small">
                                        <?php echo e(__('dental_management.odontogram.summary_surface')); ?>:
                                        <span id="summary-current-surface">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3 mb-lg-0">
                            <div class="form-group">
                                <label for="condition-selector">
                                    <i class="fas fa-tools"></i> <?php echo e(__('dental_management.treatments.singular')); ?>

                                </label>
                                <select class="form-control select2" id="condition-selector" onchange="setTool(this.value)">
                                    <option value=""><?php echo e(__('global.select_option')); ?></option>
                                    <?php $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $coverageLabel = $treatment->coverage === 'full'
                                                ? __('dental_management.treatments.coverage_full')
                                                : __('dental_management.treatments.coverage_partial');
                                        ?>
                                        <option value="treatment_<?php echo e($treatment->id); ?>">
                                            <?php echo e($treatment->name); ?> (<?php echo e($coverageLabel); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php if($showSaveActionButton): ?>
                                <button type="button" class="btn btn-success mt-2" onclick="saveCurrentAction()">
                                    <i class="fas fa-save"></i> <?php echo e(__('dental_management.odontogram.save_action')); ?>

                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-4">
                            <div class="d-flex flex-column flex-sm-row flex-lg-column" style="gap: .5rem;">
                                <button type="button" class="btn btn-outline-secondary" onclick="clearSelectedTooth()">
                                    <i class="fas fa-times"></i> <?php echo e(__('dental_management.odontogram.clear_selection')); ?>

                                </button>
                                <button type="button" class="btn btn-warning" onclick="showAdvancedOptions()">
                                    <i class="fas fa-cogs"></i> <?php echo e(__('dental_management.odontogram.advanced_options')); ?>

                                </button>
                            </div>
                        </div>
                    </div>

                    
                    <?php
                        // Sección de tratamientos registrados ocultada
                        // <div class="row mt-3">
                        //     <div class="col-12">
                        //         <div class="card h-100">
                        //             <div class="card-header d-flex justify-content-between align-items-center bg-white border-0">
                        //                 <h5 class="card-title mb-0">{{ __('dental_management.odontogram.applied_treatments') }}</h5>
                        //                 <span class="badge badge-secondary" id="summary-total-treatments">0</span>
                        //             </div>
                        //             <div class="card-body p-0">
                        //                 <div class="table-responsive" style="max-height: 260px;">
                        //                     <table class="table table-sm table-striped mb-0">
                        //                         <thead class="thead-light">
                        //                             <tr>
                        //                                 <th>{{ __('dental_management.odontogram.summary_tooth') }}</th>
                        //                                 <th>{{ __('dental_management.odontogram.summary_surface') }}</th>
                        //                                 <th>{{ __('dental_management.odontogram.summary_state') }}</th>
                        //                                 <th class="text-right">{{ __('global.actions') }}</th>
                        //                             </tr>
                        //                         </thead>
                        //                         <tbody id="treatment-summary-body"
                        //                                data-empty-text="{{ __('dental_management.odontogram.session_treatments_empty') }}"
                        //                                data-full-label="{{ __('dental_management.odontogram.full_tooth') }}">
                        //                             <tr>
                        //                                 <td colspan="4" class="text-center text-muted">
                        //                                     {{ __('dental_management.odontogram.session_treatments_empty') }}
                        //                                 </td>
                        //                             </tr>
                        //                         </tbody>
                        //                     </table>
                        //                 </div>
                        //             </div>
                        //         </div>
                        //     </div>
                        // </div>
                    ?>

                    <?php if($showDoctorFields): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="doctor_id"><?php echo e(__('dental_management.odontogram.doctor')); ?></label>
                                    <select id="doctor_id"
                                            name="doctor_id"
                                            class="form-control select2"
                                            <?php echo e($doctorFieldRequired ? 'required' : ''); ?>>
                                        <option value="" <?php echo e($selectedDoctorId ? '' : 'selected'); ?>><?php echo e(__('global.select_option')); ?></option>
                                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($doctor->id); ?>" <?php echo e((string) $selectedDoctorId === (string) $doctor->id ? 'selected' : ''); ?>>
                                                <?php echo e($doctor->name); ?> <?php echo e($doctor->last_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description"><?php echo e(__('dental_management.odontogram.description')); ?></label>
                                    <textarea id="description"
                                              name="description"
                                              class="form-control"
                                              rows="2"
                                              <?php echo e($descriptionRequired ? 'required' : ''); ?>><?php echo e($descriptionValue); ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if($showAdvancedOptions): ?>
    <?php echo $__env->make('dental_management.odontogram.partials.advanced_options_modal', ['treatments' => $treatments], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if($showLegendModal): ?>
    <?php echo $__env->make('dental_management.odontogram.partials.legend_modal', ['treatments' => $treatments], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php if (! $__env->hasRenderedOnce('05f21e01-96dd-4c1d-b3ee-e6be57bfc36a')): $__env->markAsRenderedOnce('05f21e01-96dd-4c1d-b3ee-e6be57bfc36a'); ?>
    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('adminlte/plugins/select2/js/select2.full.min.js')); ?>"></script>
        <script>
            $(document).ready(function() {
                // Initialize select2 for doctor select
                $('#doctor_id').select2({
                    theme: 'bootstrap4',
                    placeholder: '<?php echo e(__('global.select_option')); ?>',
                    allowClear: false,
                    width: '100%'
                });

                // Initialize select2 for condition selector (treatments)
                $('#condition-selector').select2({
                    theme: 'bootstrap4',
                    placeholder: '<?php echo e(__('global.select_option')); ?>',
                    allowClear: false,
                    width: '100%'
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/odontogram/partials/editor_workspace.blade.php ENDPATH**/ ?>