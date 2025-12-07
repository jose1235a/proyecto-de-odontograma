@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('adminlte/css/odontogram.css') }}">
    @endpush
@endonce

@php
    $panelId = $panelId ?? 'odontogram-treatment-history';
    $badgeId = $badgeId ?? 'odontogram-history-count';
    $cardClass = $cardClass ?? 'card-warning';
    $badgeClass = $badgeClass ?? 'badge-light';
    $cardTitle = $cardTitle ?? __('dental_management.treatment_history.title');
    $loadingText = $loadingText ?? __('global.loading');
@endphp

<div class="card {{ $cardClass }}">
    <div class="card-header">
        <h3 class="card-title mb-0 d-flex align-items-center">
            <span>
                <i class="fas fa-history"></i> {{ $cardTitle }}
            </span>
            <span class="badge {{ $badgeClass }} ml-2" id="{{ $badgeId }}">0</span>
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('dental_management.odontogram.history_registered') }}</th>
                            <th>{{ __('dental_management.odontogram.history_description') }}</th>
                            <th>{{ __('dental_management.odontogram.doctor') }}</th>
                        </tr>
                    </thead>
                    <tbody id="{{ $panelId }}">
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                <i class="fas fa-spinner fa-spin"></i> {{ $loadingText }}
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</div>
