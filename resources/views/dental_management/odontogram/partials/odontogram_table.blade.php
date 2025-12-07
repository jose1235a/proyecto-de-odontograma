@php
    $odontograms ??= collect();
    $showPatientColumn = $showPatientColumn ?? false;
    $showViewAction = $showViewAction ?? true;
    $enableDataTable = $enableDataTable ?? false;
    $returnUrl = $returnUrl ?? null;
@endphp

<div class="table-responsive">
    <table class="table table-bordered table-striped" @if($enableDataTable) data-odontogram-list @endif>
        <thead>
            <tr>
                @if($showPatientColumn)
                    <th>{{ __('dental_management.odontogram.patient') }}</th>
                @endif
                <th>{{ __('dental_management.odontogram.history_description') }}</th>
                <th>{{ __('dental_management.odontogram.doctor') }}</th>
                <th>{{ __('dental_management.odontogram.history_registered') }}</th>
                <th>{{ __('global.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($odontograms as $odontogram)
                @php
                    $latestHistory = $odontogram->latestHistory;
                    $registeredAt = optional(optional($latestHistory)->date_procedure ?? $odontogram->created_at)->format('d/m/Y H:i') ?? '-';
                    $doctorName = optional($latestHistory?->doctor)->name ?? '-';
                    $encodedReturn = $returnUrl ? '?return_url=' . urlencode($returnUrl) : '';
                @endphp
                <tr>
                    @if($showPatientColumn)
                        <td>{{ trim(($odontogram->patient->name ?? '-') . ' ' . ($odontogram->patient->last_name ?? '')) }}</td>
                    @endif
                    <td>{{ \Illuminate\Support\Str::limit(optional($latestHistory)->description, 50) ?? '-' }}</td>
                    <td>{{ $doctorName }}</td>
                    <td>{{ $registeredAt }}</td>
                    <td>
                        <div class="btn-group">
                            @if($showViewAction)
                                <a href="{{ route('dental_management.odontogram.show', $odontogram) }}"
                                   class="btn btn-info btn-sm" title="{{ __('global.show') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                            <a href="{{ route('dental_management.odontogram.edit', $odontogram) . $encodedReturn }}"
                               class="btn btn-warning btn-sm" title="{{ __('global.edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $showPatientColumn ? 5 : 4 }}" class="text-center">{{ __('global.no_records') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
