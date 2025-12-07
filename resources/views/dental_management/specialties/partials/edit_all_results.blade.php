<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.specialties.edit_all', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.specialties.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.specialties.edit_all', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.specialties.name') }}
        </a>
      </th>
      <th>{{ __('dental_management.specialties.description') }}</th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.specialties.edit_all', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.specialties.is_active') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($specialties as $specialty)
      <tr>
        <td>{{ $specialty->id }}</td>

        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $specialty->id }}"
            data-field="name"
            data-original="{{ $specialty->name }}">
          {{ $specialty->name }}
        </td>

        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $specialty->id }}"
            data-field="description"
            data-original="{{ $specialty->description ?? '' }}">
          {{ $specialty->description ?? '-' }}
        </td>

        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $specialty->id }}"
                  data-field="is_active"
                  data-original="{{ $specialty->is_active }}">
            <option value="1" {{ $specialty->is_active ? 'selected' : '' }}>{{ __('global.active') }}</option>
            <option value="0" {{ !$specialty->is_active ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
          </select>
        </td>

        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('dental_management.specialties.show', $specialty) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.specialties.edit', $specialty) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.specialties.delete', $specialty) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $specialties->links() }}
</div>
