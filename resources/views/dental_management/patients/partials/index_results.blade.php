@php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'asc');
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
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('document') }}">{{ __('dental_management.patients.document') }}</a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('name') }}">{{ __('dental_management.patients.name') }}</a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('age') }}">{{ __('dental_management.patients.age') }}</a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('allergy') }}">{{ __('dental_management.patients.allergy') }}</a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('status') }}">{{ __('global.status') }}</a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @forelse($patients as $patient)
      <tr>
        <td>{{ $loop->iteration + ($patients->currentPage() - 1) * $patients->perPage() }}</td>
        <td>{{ $patient->document ?? '-' }}</td>
        <td>{{ $patient->full_name }}</td>
        <td>{{ $patient->age ?? '-' }}</td>
        <td>{{ $patient->allergy }}</td>
        <td>{!! $patient->state_html !!}</td>
        <td>
          <div class="btn-group btn-group-sm" role="group">
            @can('patients.view')
            <a class="btn btn-light" href="{{ route('dental_management.patients.show', $patient) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            @endcan
            @can('patients.edit')
            <a class="btn btn-light" href="{{ route('dental_management.patients.edit', $patient) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            @endcan
            @can('patients.delete')
            <a class="btn btn-light" href="{{ route('dental_management.patients.delete', $patient) }}" title="{{ __('global.delete') }}">
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

<div class="d-flex justify-content-center mt-3">
  {{ $patients->appends(request()->query())->links() }}
</div>
