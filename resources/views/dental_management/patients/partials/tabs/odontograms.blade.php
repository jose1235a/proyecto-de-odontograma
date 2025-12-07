@php
    $odontograms = $patient->odontograms;
@endphp

@include('dental_management.odontogram.partials.odontogram_table', [
    'odontograms' => $odontograms,
    'showPatientColumn' => false,
    'showViewAction' => false,
    'enableDataTable' => false,
    'returnUrl' => route('dental_management.patients.show', $patient) . '?tab=odontograms',
])

<div class="row mt-4">
    <div class="col-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i> {{ __('dental_management.odontogram.treatment_history_title') }}
                </h3>
                <div class="card-tools">
                    {{ __('global.card_title_result') }}: <span class="badge badge-light" id="treatment-history-count">{{ count($treatmentHistory) }}</span>
                </div>
            </div>
            <div class="card-body">
                @if(count($treatmentHistory) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" data-odontogram-list>
                            <thead>
                                <tr>
                                    <th>{{ __('dental_management.odontogram.history_registered') }}</th>
                                    <th>{{ __('dental_management.odontogram.history_description') }}</th>
                                    <th>{{ __('dental_management.odontogram.doctor') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($treatmentHistory as $history)
                                    <tr>
                                        <td data-order="{{ $history['registered_timestamp'] ?? 0 }}">
                                            {{ $history['registered_at'] ?? '-' }}
                                        </td>
                                        <td>{{ $history['description'] }}</td>
                                        <td>{{ $history['doctor'] ? $history['doctor']['name'] . ' ' . $history['doctor']['last_name'] : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">{{ __('global.no_records') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

@include('dental_management.patients.partials.audit_card')
