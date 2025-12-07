@extends('layouts.app')

@section('title', __('dental_management.odontogram.show_title'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dental_management.odontogram.show_title') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('dental_management.odontogram.edit', $odontogram) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> {{ __('global.edit') }}
                        </a>
                        <a href="{{ route('dental_management.odontogram.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title mb-0">
                                        <i class="fas fa-history"></i> {{ __('dental_management.odontogram.history_title') }}
                                    </h3>
                                    <span class="badge badge-secondary">{{ $histories->count() }}</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 520px;">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>{{ __('dental_management.odontogram.history_registered') }}</th>
                                                    <th>{{ __('dental_management.odontogram.history_description') }}</th>
                                                    <th>{{ __('dental_management.odontogram.doctor') }}</th>
                                                    <th class="text-center">{{ __('global.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($histories as $history)
                                                    <tr class="{{ optional($activeHistory)->id === $history->id ? 'table-info' : '' }}">
                                                        <td>{{ optional($history->date_procedure ?? $history->created_at)->format('d/m/Y H:i') }}</td>
                                                        <td>{{ \Illuminate\Support\Str::limit($history->description, 40) }}</td>
                                                        <td>{{ $history->doctor?->name ?? '-' }}</td>
                                                        <td class="text-center">
                                                            <button type="button"
                                                                    class="btn btn-xs btn-outline-primary load-history"
                                                                    data-history='@json($history->canvas_data)'
                                                                    data-history-id="{{ $history->id }}">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">{{ __('global.no_records') }}</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <!-- Odontogram Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('dental_management.odontogram.patient') }}</label>
                                        <p class="form-control-plaintext">{{ $odontogram->patient->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('dental_management.odontogram.doctor') }}</label>
                                        <p class="form-control-plaintext">{{ optional($activeHistory?->doctor)->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('dental_management.odontogram.state') }}</label>
                                        <p class="form-control-plaintext">{!! $odontogram->state_html !!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('dental_management.odontogram.description') }}</label>
                                        <p class="form-control-plaintext">{{ $activeHistory->description ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Canvas + Treatment history -->
                            <div class="row">
                                <div class="col-lg-8">
                                    @include('dental_management.odontogram.partials.editor_workspace', [
                                        'patient' => $odontogram->patient,
                                        'treatments' => $treatments,
                                        'doctors' => collect(),
                                        'showPatientInfo' => false,
                                        'showControls' => false,
                                        'showDoctorFields' => false,
                                        'showAdvancedOptions' => false,
                                        'canvasWidth' => 900,
                                        'canvasHeight' => 420,
                                        'canvasHint' => null,
                                    ])
                                    <div class="text-center mt-3">
                                        <button type="button" class="btn btn-info" onclick="resetZoom()">
                                            <i class="fas fa-search-minus"></i> {{ __('dental_management.odontogram.reset_zoom') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    @include('dental_management.odontogram.partials.treatment_history_panel', [
                                        'panelId' => 'odontogram-treatment-history',
                                        'badgeId' => 'odontogram-history-count',
                                        'cardClass' => 'card-info',
                                        'badgeClass' => 'badge-primary',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('dental_management.odontogram.partials.view_scripts', [
    'initialData' => $initialData ?? [],
    'odontogram' => $odontogram,
])
@endpush
