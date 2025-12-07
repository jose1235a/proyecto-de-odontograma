<div class="row">
    <div class="col-md-6">
        <strong>{{ __('dental_management.consultations.fields.patient') }}:</strong>
        {{ $consultation->patient->name }} {{ $consultation->patient->last_name }}
    </div>
    <div class="col-md-6">
        <strong>{{ __('dental_management.consultations.fields.treatment') }}:</strong>
        {{ $consultation->treatment->name }}
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <strong>{{ __('dental_management.consultations.fields.doctor') }}:</strong>
        {{ $consultation->doctor->name }}
    </div>
    <div class="col-md-6">
        <strong>{{ __('dental_management.consultations.fields.consultation_date') }}:</strong>
        {{ $consultation->consultation_date->format('d/m/Y') }}
        @if($consultation->consultation_time)
            {{ $consultation->consultation_time->format('H:i') }}
        @endif
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <strong>{{ __('dental_management.consultations.fields.cost') }}:</strong>
        {{ $consultation->cost_formatted }}
    </div>
    <div class="col-md-6">
        <strong>{{ __('dental_management.consultations.fields.fever') }}:</strong>
        {{ $consultation->fever_formatted }}
    </div>
</div>

@if($consultation->blood_pressure)
<div class="row mt-3">
    <div class="col-md-6">
        <strong>{{ __('dental_management.consultations.fields.blood_pressure') }}:</strong>
        {{ $consultation->blood_pressure }}
    </div>
</div>
@endif

@if($consultation->description)
<div class="row mt-3">
    <div class="col-12">
        <strong>{{ __('dental_management.consultations.fields.description') }}:</strong>
        <p class="mt-2">{{ $consultation->description }}</p>
    </div>
</div>
@endif

<div class="row mt-3">
    <div class="col-md-6">
        <strong>{{ __('global.created_at') }}:</strong>
        {{ $consultation->created_at->format('d/m/Y H:i') }}
    </div>
    <div class="col-md-6">
        <strong>{{ __('global.status') }}:</strong>
        {!! $consultation->is_active ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>' !!}
    </div>
</div>