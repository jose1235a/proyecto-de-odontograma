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
                    <th>{{ __('dental_management.consultations.fields.fever') }}</th>
                    <th>{{ __('global.status') }}</th>
                    <th>{{ __('global.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultations as $consultation)
                    <tr>
                        <td>{{ $consultation->patient->name }} {{ $consultation->patient->last_name }}</td>
                        <td>{{ $consultation->treatment->name }}<br><small class="text-muted">S/ {{ number_format($consultation->treatment->cost, 2) }}</small></td>
                        <td>{{ $consultation->doctor->name }}</td>
                        <td>{{ $consultation->consultation_date->format('d/m/Y') }}</td>
                        <td>{{ $consultation->cost_formatted }}</td>
                        <td>{{ $consultation->fever_formatted }}</td>
                        <td>
                            @if($consultation->is_active)
                                <span class="badge badge-success">{{ __('global.active') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('global.inactive') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('dental_management.consultations.show', $consultation) }}"
                                   class="btn btn-light btn-sm" title="{{ __('global.view') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dental_management.consultations.edit', $consultation) }}"
                                   class="btn btn-light btn-sm" title="{{ __('global.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('dental_management.consultations.delete', $consultation) }}"
                                   class="btn btn-light btn-sm" title="{{ __('global.delete') }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
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
        <p class="text-muted">No se encontraron consultas médicas.</p>
        <a href="{{ route('dental_management.consultations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('global.create_first') }}
        </a>
    </div>
@endif