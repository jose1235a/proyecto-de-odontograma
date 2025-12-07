@if(isset($patient) && ($patient->under_medical_treatment || $patient->prone_to_bleeding || $patient->allergic_to_medication || $patient->hypertensive || $patient->diabetic || $patient->pregnant))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5>
            <i class="icon fas fa-exclamation-triangle"></i> {{ __('dental_management.patients.warning_conditions') }}
            @php
                $conditions = [];
                if($patient->under_medical_treatment) $conditions[] = __('dental_management.patients.under_medical_treatment');
                if($patient->prone_to_bleeding) $conditions[] = __('dental_management.patients.prone_to_bleeding');
                if($patient->allergic_to_medication) $conditions[] = __('dental_management.patients.allergic_to_medication');
                if($patient->hypertensive) $conditions[] = __('dental_management.patients.hypertensive');
                if($patient->diabetic) $conditions[] = __('dental_management.patients.diabetic');
                if($patient->pregnant) $conditions[] = __('dental_management.patients.pregnant');
            @endphp
            {{ implode(', ', $conditions) }}
        </h5>
    </div>
@endif