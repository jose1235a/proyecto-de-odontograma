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
                <a class="text-dark text-decoration-none" href="{{ $sortUrl('created_at', 'desc') }}">{{ __('dental_management.payments.payment_date') }}</a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="{{ $sortUrl('patient') }}">{{ __('dental_management.payments.patient') }}</a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="{{ $sortUrl('amount', 'desc') }}">{{ __('dental_management.payments.amount') }}</a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="{{ $sortUrl('payment_method') }}">{{ __('dental_management.payments.fields.payment_method') }}</a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="{{ $sortUrl('status') }}">{{ __('dental_management.payments.fields.status') }}</a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="{{ $sortUrl('reference_number') }}">{{ __('dental_management.payments.fields.reference_number') }}</a>
            </th>
            <th>{{ __('global.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($payments as $payment)
            <tr>
                <td>{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $payment->patient->name ?? '-' }}</td>
                <td><strong>{{ $payment->amount_formatted }}</strong></td>
                <td>{!! $payment->payment_method_html !!}</td>
                <td>{!! $payment->status_html !!}</td>
                <td>{{ $payment->reference_number ?? '-' }}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        @can('payments.view')
                        <a class="btn btn-light" href="{{ route('dental_management.payments.show', $payment->slug) }}?return_url={{ urlencode(request()->fullUrl()) }}" title="{{ __('global.show') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endcan
                        @can('payments.edit')
                        <a class="btn btn-light" href="{{ route('dental_management.payments.edit', $payment->slug) }}?return_url={{ urlencode(request()->fullUrl()) }}" title="{{ __('global.edit') }}">
                            <i class="fas fa-pen"></i>
                        </a>
                        @endcan
                        @can('payments.delete')
                        <a class="btn btn-light" href="{{ route('dental_management.payments.delete', $payment->slug) }}?return_url={{ urlencode(request()->fullUrl()) }}" title="{{ __('global.delete') }}">
                            <i class="fas fa-trash"></i>
                        </a>
                        @endcan
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

@if($payments->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $payments->appends(request()->query())->links() }}
    </div>
@endif
