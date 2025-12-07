<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.patients.edit_all', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.patients.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.patients.edit_all', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.patients.name') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.patients.edit_all', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.patients.last_name') }}
        </a>
      </th>
      <th>{{ __('dental_management.patients.email') }}</th>
      <th>{{ __('dental_management.patients.phone') }}</th>
      <th>{{ __('dental_management.patients.document') }}</th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.patients.edit_all', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.patients.is_active') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($patients as $patient)
      <tr>
        <td>{{ $patient->id }}</td>

        <!-- Editable name field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $patient->id }}"
            data-field="name"
            data-original="{{ $patient->name }}">
          {{ $patient->name }}
        </td>

        <!-- Editable last_name field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $patient->id }}"
            data-field="last_name"
            data-original="{{ $patient->last_name }}">
          {{ $patient->last_name ?? '-' }}
        </td>

        <!-- Editable email field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $patient->id }}"
            data-field="email"
            data-original="{{ $patient->email }}">
          {{ $patient->email }}
        </td>

        <!-- Editable phone field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $patient->id }}"
            data-field="phone"
            data-original="{{ $patient->phone }}">
          {{ $patient->phone ?? '-' }}
        </td>

        <!-- Editable document field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $patient->id }}"
            data-field="document"
            data-original="{{ $patient->document }}">
          {{ $patient->document ?? '-' }}
        </td>

        <!-- Editable status field -->
        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $patient->id }}"
                  data-field="is_active"
                  data-original="{{ $patient->is_active }}">
            <option value="1" {{ $patient->is_active ? 'selected' : '' }}>{{ __('global.active') }}</option>
            <option value="0" {{ !$patient->is_active ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
          </select>
        </td>

        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('dental_management.patients.show', $patient) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.patients.edit', $patient) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.patients.delete', $patient) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $patients->links() }}
</div>