<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> Función de edición masiva próximamente disponible.
</div>

@if($consultations->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{{ __('dental_management.consultations.fields.patient') }}</th>
                    <th>{{ __('dental_management.consultations.fields.treatment') }}</th>
                    <th>{{ __('dental_management.consultations.fields.doctor') }}</th>
                    <th>{{ __('dental_management.consultations.fields.consultation_date') }}</th>
                    <th>{{ __('dental_management.consultations.fields.cost') }}</th>
                    <th>{{ __('global.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultations as $consultation)
                    <tr>
                        <td>{{ $consultation->patient->name }} {{ $consultation->patient->last_name }}</td>
                        <td>{{ $consultation->treatment->name }}</td>
                        <td>{{ $consultation->doctor->name }}</td>
                        <td>{{ $consultation->consultation_date->format('d/m/Y') }}</td>
                        <td>{{ $consultation->cost_formatted }}</td>
                        <td>
                            @if($consultation->is_active)
                                <span class="badge badge-success">{{ __('global.active') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('global.inactive') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $consultations->appends(request()->query())->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-stethoscope fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">{{ __('global.no_records') }}</h4>
    </div>
@endif