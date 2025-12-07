@php
    $fullName = trim($patient->name . ' ' . ($patient->last_name ?? ''));
    $warningConditions = [
        [
            'visible' => $patient->under_medical_treatment,
            'label' => __('dental_management.patients.conditions.under_medical_treatment'),
            'value' => $patient->under_medical_treatment_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->prone_to_bleeding,
            'label' => __('dental_management.patients.conditions.prone_to_bleeding'),
            'value' => $patient->prone_to_bleeding_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->allergic_to_medication,
            'label' => __('dental_management.patients.conditions.allergic_to_medication'),
            'value' => $patient->allergic_to_medication_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->hypertensive,
            'label' => __('dental_management.patients.conditions.hypertensive'),
            'value' => $patient->hypertensive_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->diabetic,
            'label' => __('dental_management.patients.conditions.diabetic'),
            'value' => $patient->diabetic_description ?: __('global.yes'),
        ],
        [
            'visible' => $patient->pregnant,
            'label' => __('dental_management.patients.conditions.pregnant'),
            'value' => $patient->pregnant_description ?: __('global.yes'),
        ],
    ];
    $warningConditions = array_values(array_filter($warningConditions, fn ($condition) => $condition['visible']));
@endphp

<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>{{ __('dental_management.patients.email') }}</label>
      <p class="form-control-plaintext">{{ $patient->email ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>{{ __('dental_management.patients.address') }}</label>
      <p class="form-control-plaintext">{{ $patient->address ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>{{ __('dental_management.patients.emergency_contact') }}</label>
      <p class="form-control-plaintext">{{ $patient->emergency_contact ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>{{ __('dental_management.patients.birth_date') }}</label>
      <p class="form-control-plaintext">
        {{ $patient->birth_date ? $patient->birth_date->format('d/m/Y') : '-' }}
      </p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>{{ __('dental_management.patients.total_debt') }}</label>
      <p class="form-control-plaintext">
        @if($patient->total_debt > 0)
          <span class="text-danger font-weight-bold">{{ $patient->total_debt_formatted }}</span>
        @else
          <span class="text-success">{{ __('dental_management.patients.no_debt') }}</span>
        @endif
      </p>
    </div>
  </div>
  <div class="col-md-9">
    <!-- Reserved space for additional financial information -->
  </div>
</div>

@if(count($warningConditions))
  @foreach(array_chunk($warningConditions, 4) as $chunk)
    <div class="row">
      @foreach($chunk as $condition)
        <div class="col-md-3">
          <p class="form-control-plaintext">
            <i class="fas fa-exclamation-triangle text-warning"></i>
            <strong>{{ $condition['label'] }}:</strong>
            <span class="text-danger font-weight-bold">{{ $condition['value'] }}</span>
          </p>
        </div>
      @endforeach
    </div>
  @endforeach
@endif

<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>{{ __('dental_management.patients.observations') }}</label>
      <p class="form-control-plaintext">{{ $patient->observations ?: '-' }}</p>
    </div>
  </div>
</div>
