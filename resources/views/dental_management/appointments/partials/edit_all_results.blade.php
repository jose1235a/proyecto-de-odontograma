<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>{{ __('dental_management.appointments.treatment') }}</th>
      <th>{{ __('dental_management.appointments.doctor') }}</th>
      <th>{{ __('dental_management.appointments.patient') }}</th>
      <th>{{ __('dental_management.appointments.appointment_date') }}</th>
      <th>{{ __('dental_management.appointments.status') }}</th>
      <th class="text-right">{{ __('dental_management.appointments.cost') }}</th>
      <th class="text-right">{{ __('dental_management.appointments.paid') }}</th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @forelse($appointments as $appointment)
      <tr>
        <td>{{ $appointment->treatment->name ?? '-' }}</td>
        <td>{{ $appointment->doctor ? trim($appointment->doctor->name . ' ' . ($appointment->doctor->last_name ?? '')) : '-' }}</td>
        <td>{{ $appointment->patient ? trim($appointment->patient->name . ' ' . ($appointment->patient->last_name ?? '')) : '-' }}</td>
        <td>
          @if($appointment->appointment_date && $appointment->appointment_time)
            {{ $appointment->appointment_date->format('d/m/Y') }} {{ $appointment->appointment_time->format('H:i') }}
          @else
            -
          @endif
        </td>
        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $appointment->id }}"
                  data-field="status"
                  data-original="{{ $appointment->status }}">
            <option value="scheduled" {{ $appointment->status === 'scheduled' ? 'selected' : '' }}>
              {{ __('dental_management.appointments.status_assigned') }}
            </option>
            <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>
              {{ __('dental_management.appointments.status_attended') }}
            </option>
          </select>
        </td>
        <td class="editable-cell text-right"
            contenteditable="true"
            data-id="{{ $appointment->id }}"
            data-field="cost"
            data-original="{{ number_format($appointment->cost ?? 0, 2, '.', '') }}">
          {{ number_format($appointment->cost ?? 0, 2) }}
        </td>
        <td class="editable-cell text-right"
            contenteditable="true"
            data-id="{{ $appointment->id }}"
            data-field="paid"
            data-original="{{ number_format($appointment->paid ?? 0, 2, '.', '') }}">
          {{ number_format($appointment->paid ?? 0, 2) }}
        </td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('dental_management.appointments.show', $appointment) }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.appointments.edit', $appointment) }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.appointments.delete', $appointment) }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="8" class="text-center">{{ __('global.no_records') }}</td>
      </tr>
    @endforelse
  </tbody>
</table>

@if($appointments->hasPages())
  <div class="d-flex justify-content-center mt-3">
    {{ $appointments->appends(request()->query())->links() }}
  </div>
@endif
