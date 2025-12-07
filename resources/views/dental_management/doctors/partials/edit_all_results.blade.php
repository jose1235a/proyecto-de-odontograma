<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.doctors.edit_all', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.doctors.id') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.doctors.edit_all', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.doctors.name') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.doctors.edit_all', array_merge(request()->all(), ['sort' => 'last_name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.doctors.last_name') }}
        </a>
      </th>
      <th>{{ __('dental_management.doctors.document_type') }}</th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.doctors.edit_all', array_merge(request()->all(), ['sort' => 'document', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.doctors.document') }}
        </a>
      </th>
      <th>{{ __('dental_management.doctors.specialty') }}</th>
      <th>{{ __('dental_management.doctors.email') }}</th>
      <th>{{ __('dental_management.doctors.phone') }}</th>
      <th>{{ __('dental_management.doctors.address') }}</th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.doctors.edit_all', array_merge(request()->all(), ['sort' => 'is_active', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.doctors.is_active') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($doctors as $doctor)
      <tr>
        <td>{{ $doctor->id }}</td>

        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $doctor->id }}"
            data-field="name"
            data-original="{{ $doctor->name }}">
          {{ $doctor->name }}
        </td>

        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $doctor->id }}"
            data-field="last_name"
            data-original="{{ $doctor->last_name }}">
          {{ $doctor->last_name }}
        </td>

        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $doctor->id }}"
                  data-field="document_type"
                  data-original="{{ $doctor->document_type }}">
            <option value="dni" {{ $doctor->document_type === 'dni' ? 'selected' : '' }}>DNI</option>
            <option value="passport" {{ $doctor->document_type === 'passport' ? 'selected' : '' }}>PASSPORT</option>
            <option value="other" {{ $doctor->document_type === 'other' ? 'selected' : '' }}>OTHER</option>
          </select>
        </td>

        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $doctor->id }}"
            data-field="document"
            data-original="{{ $doctor->document }}">
          {{ $doctor->document }}
        </td>

        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $doctor->id }}"
                  data-field="specialty_id"
                  data-original="{{ $doctor->specialty_id }}">
            @foreach($specialties as $specialty)
              <option value="{{ $specialty->id }}" {{ $doctor->specialty_id == $specialty->id ? 'selected' : '' }}>
                {{ $specialty->name }}
              </option>
            @endforeach
          </select>
        </td>

        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $doctor->id }}"
            data-field="email"
            data-original="{{ $doctor->email }}">
          {{ $doctor->email }}
        </td>

        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $doctor->id }}"
            data-field="phone"
            data-original="{{ $doctor->phone }}">
          {{ $doctor->phone ?? '-' }}
        </td>

        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $doctor->id }}"
            data-field="address"
            data-original="{{ $doctor->address }}">
          {{ $doctor->address ?? '-' }}
        </td>

        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $doctor->id }}"
                  data-field="is_active"
                  data-original="{{ $doctor->is_active }}">
            <option value="1" {{ $doctor->is_active ? 'selected' : '' }}>{{ __('global.active') }}</option>
            <option value="0" {{ !$doctor->is_active ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
          </select>
        </td>

        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('dental_management.doctors.show', $doctor) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.doctors.edit', $doctor) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.doctors.delete', $doctor) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $doctors->links() }}
</div>
