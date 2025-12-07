<?php if(isset($patient) && ($patient->under_medical_treatment || $patient->prone_to_bleeding || $patient->allergic_to_medication || $patient->hypertensive || $patient->diabetic || $patient->pregnant)): ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5>
            <i class="icon fas fa-exclamation-triangle"></i> <?php echo e(__('dental_management.patients.warning_conditions')); ?>

            <?php
                $conditions = [];
                if($patient->under_medical_treatment) $conditions[] = __('dental_management.patients.under_medical_treatment');
                if($patient->prone_to_bleeding) $conditions[] = __('dental_management.patients.prone_to_bleeding');
                if($patient->allergic_to_medication) $conditions[] = __('dental_management.patients.allergic_to_medication');
                if($patient->hypertensive) $conditions[] = __('dental_management.patients.hypertensive');
                if($patient->diabetic) $conditions[] = __('dental_management.patients.diabetic');
                if($patient->pregnant) $conditions[] = __('dental_management.patients.pregnant');
            ?>
            <?php echo e(implode(', ', $conditions)); ?>

        </h5>
    </div>
<?php endif; ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/odontogram/partials/patient_conditions_alert.blade.php ENDPATH**/ ?>