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
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('name') }}">{{ __('dental_management.treatments.name') }}</a>
      </th>
      <th class="text-right">
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('cost') }}">{{ __('dental_management.treatments.cost') }}</a>
      </th>
      <th class="text-center">
        <a class="text-dark text-decoration-none" href="{{ $sortUrl('is_active') }}">{{ __('dental_management.treatments.is_active') }}</a>
      </th>
      <th class="text-center">{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @forelse($treatments as $treatment)
      <tr>
        <td>{{ $loop->iteration + ($treatments->currentPage() - 1) * $treatments->perPage() }}</td>
        <td>
          <strong>{{ $treatment->name }}</strong>
          @php
              $coverageKey = $treatment->coverage === 'full' ? 'coverage_full' : 'coverage_partial';
              $coverageClass = $treatment->coverage === 'full' ? 'badge-info' : 'badge-secondary';
          @endphp
          <div class="mt-1">
            <span class="badge {{ $coverageClass }}">{{ __('dental_management.treatments.' . $coverageKey) }}</span>
          </div>
          @if($treatment->description)
            <div class="text-muted small mt-1">{{ Str::limit($treatment->description, 80) }}</div>
          @endif
        </td>
        <td class="text-right">{{ $treatment->getCostFormattedAttribute() }}</td>
        <td class="text-center">{!! $treatment->getStateHtmlAttribute() !!}</td>
        <td class="text-center">
          <div class="btn-group btn-group-sm" role="group">
            @can('treatments.view')
            <a class="btn btn-light" href="{{ route('dental_management.treatments.show', $treatment) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            @endcan
            @can('treatments.edit')
            <a class="btn btn-light" href="{{ route('dental_management.treatments.edit', $treatment) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            @endcan
            @can('treatments.delete')
            <a class="btn btn-light" href="{{ route('dental_management.treatments.delete', $treatment) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
            @endcan
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="5" class="text-center">
          <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle"></i> {{ __('global.no_records_found') }}
          </div>
        </td>
      </tr>
    @endforelse
  </tbody>
</table>

@if($treatments->hasPages())
  <div class="d-flex justify-content-center mt-3">
    {{ $treatments->appends(request()->query())->links() }}
  </div>
@endif
