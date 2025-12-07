@php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'desc');
    $sortUrl = function (string $column, string $defaultDirection = 'asc') use ($currentSort, $currentDirection) {
        $direction = $currentSort === $column
            ? ($currentDirection === 'asc' ? 'desc' : 'asc')
            : $defaultDirection;
        return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $direction, 'page' => 1]);
    };
@endphp

<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('id') }}">N°</a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('appointment_date', 'desc') }}">{{ __('dental_management.appointments.appointment_date') }}</a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('treatment') }}">{{ __('dental_management.appointments.treatment') }}</a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('doctor') }}">{{ __('dental_management.appointments.doctor') }}</a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('patient') }}">{{ __('dental_management.appointments.patient') }}</a>
      </th>
      <th class="text-center">
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('status') }}">{{ __('global.status') }}</a>
      </th>
      <th class="text-center">{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @forelse($appointments as $appointment)
      <tr>
        <td>{{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}</td>
        <td>
          @if($appointment->appointment_date && $appointment->appointment_time)
            {{ $appointment->appointment_date->format('d/m/Y') }} {{ $appointment->appointment_time->format('H:i') }}
          @else
            -
          @endif
        </td>
        <td>{{ $appointment->treatment->name ?? '-' }}</td>
        @php($doctorName = $appointment->doctor ? trim($appointment->doctor->name . ' ' . ($appointment->doctor->last_name ?? '')) : '-')
        @php($patientName = $appointment->patient ? trim($appointment->patient->name . ' ' . ($appointment->patient->last_name ?? '')) : '-')
        <td>{{ $doctorName }}</td>
        <td>{{ $patientName }}</td>
        <td class="text-center">{!! $appointment->status_html !!}</td>
        <td class="text-center">
          <div class="btn-group btn-group-sm" role="group">
            @can('appointments.view')
            <a class="btn btn-light" href="{{ route('dental_management.appointments.show', $appointment) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            @endcan
            @can('appointments.edit')
            <a class="btn btn-light" href="{{ route('dental_management.appointments.edit', $appointment) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            @endcan
            @can('appointments.delete')
            <a class="btn btn-light" href="{{ route('dental_management.appointments.delete', $appointment) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
            @endcan
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="7" class="text-center">{{ __('global.no_records') }}</td>
      </tr>
    @endforelse
  </tbody>
</table>

@if($appointments->hasPages())
  <div class="d-flex justify-content-center mt-3">
    {{ $appointments->appends(request()->query())->links() }}
  </div>
@endif
