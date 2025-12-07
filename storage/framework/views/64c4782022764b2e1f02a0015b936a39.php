

<?php $__env->startSection('title', __('dental_management.patients.show_title')); ?>
<?php $__env->startSection('title_navbar', __('dental_management.patients.plural')); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('dental_management.odontogram.partials.patient_conditions_alert', ['patient' => $patient], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-database"></i> <?php echo e(__('dental_management.patients.show_title')); ?>

        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center mb-3">
          <div class="d-flex justify-content-center align-items-center mb-3">
            <img src="<?php echo e($patient->photo_url); ?>" alt="Foto del paciente" class="rounded-circle mr-4" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #007bff;">
            <div class="text-left">
              <h3 class="font-weight-bold text-dark mb-1"><?php echo e($patient->name); ?> <?php echo e($patient->last_name); ?></h3>
              <p class="h6 text-muted mb-0">
                DNI: <?php echo e($patient->document); ?>

                <?php if($patient->birth_date): ?>
                  || EDAD: <?php echo e(\Carbon\Carbon::parse($patient->birth_date)->age); ?> años
                <?php endif; ?>
                <?php if($patient->phone): ?>
                  || TEL: <?php echo e($patient->phone); ?>

                <?php endif; ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-center">
        <a href="<?php echo e(route('dental_management.patients.index')); ?>" class="btn btn-secondary mr-2" title="<?php echo e(__('global.back')); ?>">
          <i class="fas fa-arrow-left"></i> <?php echo e(__('global.back')); ?>

        </a>
        <a href="<?php echo e(route('dental_management.patients.edit', $patient)); ?>" class="btn btn-warning" title="<?php echo e(__('global.edit')); ?>">
          <i class="fas fa-edit"></i> <?php echo e(__('global.edit')); ?>

        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-info card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="patient-tabs" role="tablist">
           <li class="nav-item">
             <a class="nav-link active" id="patient-info-tab" data-toggle="pill" href="#patient-info" role="tab" aria-controls="patient-info" aria-selected="true">
               <i class="fas fa-user"></i> <?php echo e(__('dental_management.patients.info_title')); ?>

             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" id="consultations-tab" data-toggle="pill" href="#consultations" role="tab" aria-controls="consultations" aria-selected="false">
               <i class="fas fa-stethoscope"></i> <?php echo e(__('dental_management.consultations.clinical_history')); ?>

               <span class="badge badge-light"><?php echo e($patient->consultations->count()); ?></span>
             </a>
           </li>
          <li class="nav-item">
            <a class="nav-link" id="odontograms-tab" data-toggle="pill" href="#odontograms" role="tab" aria-controls="odontograms" aria-selected="false">
              <i class="fas fa-tooth"></i> <?php echo e(__('dental_management.odontogram.plural')); ?>

              <span class="badge badge-light"><?php echo e($patient->odontograms->count()); ?></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="appointments-tab" data-toggle="pill" href="#appointments" role="tab" aria-controls="appointments" aria-selected="false">
              <i class="fas fa-calendar-alt"></i> <?php echo e(__('dental_management.appointments.plural')); ?>

              <span class="badge badge-light"><?php echo e($patient->appointments->count()); ?></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="payments-tab" data-toggle="pill" href="#payments" role="tab" aria-controls="payments" aria-selected="false">
              <i class="fas fa-money-bill-wave"></i> <?php echo e(__('dental_management.payments.plural')); ?>

              <span class="badge badge-light"><?php echo e($payments->count()); ?></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="images-tab" data-toggle="pill" href="#images" role="tab" aria-controls="images" aria-selected="false">
              <i class="fas fa-images"></i> <?php echo e(__('dental_management.patients.images')); ?>

            </a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="patient-tabs-content">
           <!-- Patient Info Tab -->
           <div class="tab-pane fade show active" id="patient-info" role="tabpanel" aria-labelledby="patient-info-tab">
             <?php echo $__env->make('dental_management.patients.partials.form_show', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

              <?php echo $__env->make('dental_management.patients.partials.audit_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
           </div>

            <!-- Consultations Tab -->
            <div class="tab-pane fade" id="consultations" role="tabpanel" aria-labelledby="consultations-tab">
            <div class="row">
              <div class="col-lg-12">
                <div class="card card-info rounded">
                  <div class="card-header">
                    <h3 class="card-title pt-1">
                      <i class="fas fa-table"></i> <?php echo e(__('global.card_title_result')); ?>:
                      <?php if($patient->consultations->count() > 0): ?>
                        <?php echo e($patient->consultations->count()); ?>

                      <?php else: ?>
                        0
                      <?php endif; ?>
                    </h3>
                    <div class="card-tools">
                      <a class="btn btn-sm btn-success mr-2" href="<?php echo e(route('dental_management.consultations.create')); ?>?patient_id=<?php echo e($patient->slug); ?>">
                        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline"><?php echo e(__('dental_management.consultations.new_consultation')); ?></span>
                      </a>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <?php if($patient->consultations->count() > 0): ?>
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="patient-consultations-table">
                          <thead>
                            <tr>
                              <th><?php echo e(__('dental_management.consultations.consultation_date')); ?></th>
                              <th><?php echo e(__('dental_management.consultations.description')); ?></th>
                              <th><?php echo e(__('dental_management.consultations.doctor')); ?></th>
                              <th><?php echo e(__('global.actions')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                                $consultations = $patient->consultations->sort(function ($a, $b) {
                                    $aDate = $a->consultation_date ? $a->consultation_date->timestamp : 0;
                                    $bDate = $b->consultation_date ? $b->consultation_date->timestamp : 0;
                                    if ($aDate != $bDate) {
                                        return $bDate - $aDate; // Descending date
                                    }
                                    $aTime = $a->consultation_time ? strtotime($a->consultation_time->format('H:i:s')) : 0;
                                    $bTime = $b->consultation_time ? strtotime($b->consultation_time->format('H:i:s')) : 0;
                                    return $bTime - $aTime; // Descending time
                                });
                                $firstConsultation = $consultations->first();
                            ?>
                            <?php $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td data-order="<?php echo e($consultation->consultation_date ? $consultation->consultation_date->timestamp : 0); ?>">
                                  <?php if($consultation->consultation_date && $consultation->consultation_time): ?>
                                    <?php echo e($consultation->consultation_date->format('d/m/Y')); ?> <?php echo e($consultation->consultation_time->format('H:i')); ?>

                                  <?php else: ?>
                                    -
                                  <?php endif; ?>
                                </td>
                                <td><?php echo e($consultation->treatment->name ?? '-'); ?></td>
                                <td><?php echo e($consultation->doctor->name ?? '-'); ?></td>
                                <td>
                                  <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('dental_management.consultations.edit', ['consultation' => $consultation, 'return_url' => route('dental_management.patients.show', $patient) . '?tab=consultations'])); ?>" class="btn btn-light btn-sm" title="<?php echo e(__('global.edit')); ?>">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if($consultation->id !== $firstConsultation->id): ?>
                                    <a href="<?php echo e(route('dental_management.consultations.delete', ['consultation' => $consultation, 'return_url' => route('dental_management.patients.show', $patient) . '?tab=consultations'])); ?>" class="btn btn-light btn-sm" title="<?php echo e(__('global.delete')); ?>">
                                      <i class="fas fa-trash"></i>
                                    </a>
                                    <?php endif; ?>
                                  </div>
                                </td>
                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                      </div>
                    <?php else: ?>
                      <p class="text-center text-muted"><?php echo e(__('global.no_records')); ?></p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <?php echo $__env->make('dental_management.patients.partials.audit_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>

          <!-- Odontograms Tab -->
          <div class="tab-pane fade" id="odontograms" role="tabpanel" aria-labelledby="odontograms-tab">
            <?php echo $__env->make('dental_management.patients.partials.tabs.odontograms', ['patient' => $patient], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>

          <!-- Appointments Tab -->
          <div class="tab-pane fade" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
            <div class="row">
              <div class="col-lg-12">
                <div class="card card-info rounded">
                  <div class="card-header">
                    <h3 class="card-title pt-1">
                      <i class="fas fa-table"></i> <?php echo e(__('global.card_title_result')); ?>:
                      <?php if($patient->appointments->count() > 0): ?>
                        <?php echo e($patient->appointments->count()); ?>

                      <?php else: ?>
                        0
                      <?php endif; ?>
                    </h3>
                    <div class="card-tools">
                      <a class="btn btn-sm btn-primary mr-2" href="<?php echo e(route('dental_management.appointments.create')); ?>?patient_id=<?php echo e($patient->slug); ?>&return_url=<?php echo e(urlencode(route('dental_management.patients.show', $patient) . '?tab=appointments')); ?>">
                        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.create')); ?></span>
                      </a>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <?php if($patient->appointments->count() > 0): ?>
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="patient-appointments-table">
                          <thead>
                            <tr>
                              <th><?php echo e(__('dental_management.appointments.appointment_date')); ?></th>
                              <th><?php echo e(__('dental_management.doctors.singular')); ?></th>
                              <th><?php echo e(__('dental_management.treatments.singular')); ?></th>
                              <th><?php echo e(__('dental_management.appointments.status')); ?></th>
                              <th><?php echo e(__('global.actions')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                                $sortedAppointments = $patient->appointments->sortByDesc('appointment_date')->sortByDesc('appointment_time');
                            ?>
                            <?php $__currentLoopData = $sortedAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td data-order="<?php echo e($appointment->appointment_date ? ($appointment->appointment_date->timestamp + ($appointment->appointment_time ? $appointment->appointment_time->hour * 3600 + $appointment->appointment_time->minute * 60 + $appointment->appointment_time->second : 0)) : 0); ?>">
                                  <?php if($appointment->appointment_date && $appointment->appointment_time): ?>
                                    <?php echo e($appointment->appointment_date->format('d/m/Y')); ?> <?php echo e($appointment->appointment_time->format('H:i')); ?>

                                  <?php else: ?>
                                    -
                                  <?php endif; ?>
                                </td>
                                <td><?php echo e($appointment->doctor->name ?? '-'); ?></td>
                                <td><?php echo e($appointment->treatment->name ?? '-'); ?></td>
                                <td><?php echo $appointment->status_html; ?></td>
                                <td>
                                  <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('dental_management.appointments.edit', ['appointment' => $appointment, 'return_url' => route('dental_management.patients.show', $patient)])); ?>" class="btn btn-light btn-sm" title="<?php echo e(__('global.edit')); ?>">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo e(route('dental_management.appointments.delete', ['appointment' => $appointment, 'return_url' => route('dental_management.patients.show', $patient)])); ?>" class="btn btn-light btn-sm" title="<?php echo e(__('global.delete')); ?>">
                                      <i class="fas fa-trash"></i>
                                    </a>
                                  </div>
                                </td>
                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                      </div>
                    <?php else: ?>
                      <p class="text-center text-muted"><?php echo e(__('dental_management.consultations.no_consultations')); ?></p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <?php echo $__env->make('dental_management.patients.partials.audit_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>

          <!-- Payments Tab -->
          <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
            <div class="row">
              <div class="col-lg-12">
                <div class="card card-info rounded">
                  <div class="card-header">
                    <h3 class="card-title pt-1">
                      <i class="fas fa-table"></i> <?php echo e(__('global.card_title_result')); ?>:
                      <?php if($payments->count() > 0): ?>
                        <?php echo e($payments->count()); ?>

                      <?php else: ?>
                        0
                      <?php endif; ?>
                    </h3>
                    <div class="card-tools">
                      <a class="btn btn-sm btn-success mr-2" href="<?php echo e(route('dental_management.payments.create')); ?>?patient_id=<?php echo e($patient->slug); ?>&return_url=<?php echo e(urlencode(route('dental_management.patients.show', $patient) . '?tab=payments')); ?>">
                        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline"><?php echo e(__('global.create')); ?> <?php echo e(__('dental_management.payments.singular')); ?></span>
                      </a>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <?php if($payments->count() > 0): ?>
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="patient-payments-table">
                          <thead>
                            <tr>
                              <th><?php echo e(__('dental_management.payments.payment_date')); ?></th>
                              <th><?php echo e(__('dental_management.payments.amount')); ?></th>
                              <th><?php echo e(__('dental_management.payments.fields.payment_method')); ?></th>
                              <th><?php echo e(__('dental_management.payments.fields.status')); ?></th>
                              <th><?php echo e(__('global.actions')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td data-order="<?php echo e($payment->created_at->timestamp); ?>"><?php echo e($payment->created_at->format('d/m/Y H:i')); ?></td>
                                <td><strong><?php echo e($payment->amount_formatted); ?></strong></td>
                                <td><?php echo $payment->payment_method_html; ?></td>
                                <td><?php echo $payment->status_html; ?></td>
                                <td>
                                  <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('dental_management.payments.edit', $payment->slug)); ?>?patient_id=<?php echo e($patient->id); ?>&return_url=<?php echo e(urlencode(route('dental_management.patients.show', $patient) . '?tab=payments')); ?>" class="btn btn-light btn-sm" title="<?php echo e(__('global.edit')); ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo e(route('dental_management.payments.delete', $payment->slug)); ?>?return_url=<?php echo e(urlencode(route('dental_management.patients.show', $patient) . '?tab=payments')); ?>" class="btn btn-light btn-sm" title="<?php echo e(__('global.delete')); ?>">
                                      <i class="fas fa-trash"></i>
                                    </a>
                                  </div>
                                </td>
                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                      </div>
                    <?php else: ?>
                      <p class="text-center text-muted"><?php echo e(__('global.no_records')); ?></p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <?php echo $__env->make('dental_management.patients.partials.audit_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>




          <!-- Images Tab -->
          <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
            <?php echo $__env->make('dental_management.patients.partials.form_show_images', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php echo $__env->make('dental_management.patients.partials.audit_card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (! $__env->hasRenderedOnce('d55e0235-859a-445b-a7e1-83a61d5bf4aa')): $__env->markAsRenderedOnce('d55e0235-859a-445b-a7e1-83a61d5bf4aa'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
<style>
[data-odontogram-list] thead th.sorting:before,
[data-odontogram-list] thead th.sorting_asc:before,
[data-odontogram-list] thead th.sorting_desc:before,
[data-odontogram-list] thead th.sorting:after,
[data-odontogram-list] thead th.sorting_asc:after,
[data-odontogram-list] thead th.sorting_desc:after {
    content: none !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('adminlte/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('dental_management.patients.partials.show_scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/show.blade.php ENDPATH**/ ?>