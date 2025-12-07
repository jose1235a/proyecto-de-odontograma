<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{{ __('dental_management.appointment_history.date') }}</th>
                <th>{{ __('dental_management.appointment_history.appointment') }}</th>
                <th>{{ __('dental_management.appointment_history.action') }}</th>
                <th>{{ __('dental_management.appointment_history.changed_by') }}</th>
                <th>{{ __('dental_management.appointment_history.notes') }}</th>
                <th>{{ __('global.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointmentHistories as $history)
                <tr>
                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <strong>{{ $history->appointment->patient->name ?? '-' }}</strong><br>
                        <small class="text-muted">{{ $history->appointment->appointment_date_time ?? '-' }}</small>
                    </td>
                    <td>{!! $history->action_html !!}</td>
                    <td>{{ $history->changer->name ?? '-' }}</td>
                    <td>{{ Str::limit($history->notes, 50) ?? '-' }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('dental_management.appointment_history.show', $history) }}"
                               class="btn btn-info btn-sm" title="{{ __('global.show') }}">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">{{ __('global.no_records') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($appointmentHistories->hasPages())
    <div class="d-flex justify-content-center">
        {{ $appointmentHistories->appends(request()->query())->links() }}
    </div>
@endif