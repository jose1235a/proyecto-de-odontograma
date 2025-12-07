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

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>
                    <a class="text-dark text-decoration-none" href="{{ $sortUrl('id') }}">N°</a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="{{ $sortUrl('document') }}">{{ __('dental_management.doctors.document') }}</a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="{{ $sortUrl('name') }}">{{ __('dental_management.doctors.name') }}</a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="{{ $sortUrl('specialty') }}">{{ __('dental_management.doctors.specialty') }}</a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="{{ $sortUrl('address') }}">{{ __('dental_management.doctors.address') }}</a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="{{ $sortUrl('email') }}">{{ __('dental_management.doctors.email') }}</a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="{{ $sortUrl('phone') }}">{{ __('dental_management.doctors.phone') }}</a>
                </th>
                <th>
                    <a class="text-dark text-decoration-none" href="{{ $sortUrl('status') }}">{{ __('global.status') }}</a>
                </th>
                <th>{{ __('global.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($doctors as $doctor)
                <tr>
                    <td>{{ $loop->iteration + ($doctors->currentPage() - 1) * $doctors->perPage() }}</td>
                    <td>{{ $doctor->document_type }} {{ $doctor->document }}</td>
                    <td>{{ $doctor->full_name }}</td>
                    <td>
                        @forelse($doctor->specialties as $specialty)
                            <span class="badge badge-primary">{{ $specialty->name }}</span>
                        @empty
                            -
                        @endforelse
                    </td>
                    <td>{{ Str::limit($doctor->address, 30) ?? '-' }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->phone ?? '-' }}</td>
                    <td>{!! $doctor->state_html !!}</td>
                    <td>
                      <div class="btn-group btn-group-sm" role="group">
                        @can('doctors.view')
                        <a class="btn btn-light" href="{{ route('dental_management.doctors.show', $doctor) }}" title="{{ __('global.show') }}">
                          <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('doctors.edit')
                        <a class="btn btn-light" href="{{ route('dental_management.doctors.edit', $doctor) }}" title="{{ __('global.edit') }}">
                          <i class="fas fa-pen"></i>
                        </a>
                        @endcan
                        @can('doctors.delete')
                        <a class="btn btn-light" href="{{ route('dental_management.doctors.delete', $doctor) }}" title="{{ __('global.delete') }}">
                          <i class="fas fa-trash"></i>
                        </a>
                        @endcan
                      </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">{{ __('global.no_records') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($doctors->hasPages())
    <div class="d-flex justify-content-center">
        {{ $doctors->appends(request()->query())->links() }}
    </div>
@endif
