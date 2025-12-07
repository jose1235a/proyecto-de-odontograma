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
                <a class="text-dark text-decoration-none" href="{{ $sortUrl('id') }}">
                    {{ __('dental_management.specialties.id') }}
                </a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="{{ $sortUrl('name') }}">
                    {{ __('dental_management.specialties.name') }}
                </a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="{{ $sortUrl('is_active') }}">
                    {{ __('global.status') }}
                </a>
            </th>
            <th>{{ __('global.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($specialties as $specialty)
            <tr>
                <td>{{ $loop->iteration + $specialties->firstItem() - 1 }}</td>
                <td>{{ $specialty->name }}</td>
                <td>{!! $specialty->state_html !!}</td>
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
        @empty
            <tr>
                <td colspan="4" class="text-center">{{ __('global.no_records') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $specialties->appends(request()->query())->links() }}
</div>
