<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.treatments.edit_all', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('global.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.treatments.edit_all', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.treatments.name') }}
        </a>
      </th>
      <th class="text-right">
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.treatments.edit_all', array_merge(request()->all(), ['sort' => 'cost', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.treatments.cost') }}
        </a>
      </th>
      <th class="text-center">
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.treatments.edit_all', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.treatments.is_active') }}
        </a>
      </th>
      <th class="text-center">{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @forelse($treatments as $treatment)
      <tr>
        <td>{{ $treatment->id }}</td>
        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $treatment->id }}"
            data-field="name"
            data-original="{{ $treatment->name }}">
          {{ $treatment->name }}
        </td>
        <td class="editable-cell text-right"
            contenteditable="true"
            data-id="{{ $treatment->id }}"
            data-field="cost"
            data-original="{{ number_format($treatment->cost, 2, '.', '') }}">
          {{ number_format($treatment->cost, 2, '.', '') }}
        </td>
        <td class="text-center">
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $treatment->id }}"
                  data-field="is_active"
                  data-original="{{ $treatment->is_active }}">
            <option value="1" {{ $treatment->is_active ? 'selected' : '' }}>{{ __('global.active') }}</option>
            <option value="0" {{ !$treatment->is_active ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
          </select>
        </td>
        <td class="text-center">
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('dental_management.treatments.show', $treatment) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.treatments.edit', $treatment) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.treatments.delete', $treatment) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="5" class="text-center">
          <div class="alert alert-info mb-0">
            {{ __('global.no_records_found') }}
          </div>
        </td>
      </tr>
    @endforelse
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $treatments->links() }}
</div>
