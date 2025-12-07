@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('adminlte/css/odontogram.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endpush
@endonce

@php
    $patient ??= null;
    $treatments ??= collect();
    $doctors ??= collect();
    $showPatientInfo = $showPatientInfo ?? true;
    $showControls = $showControls ?? true;
    $showDoctorFields = $showDoctorFields ?? $showControls;
    $showLegendButton = $showLegendButton ?? true;
    $showLegendModal = $showLegendModal ?? true;
    $showAdvancedOptions = $showAdvancedOptions ?? $showControls;
    $doctorFieldRequired = $doctorFieldRequired ?? false;
    $descriptionRequired = $descriptionRequired ?? false;
    $selectedDoctorId = $selectedDoctorId ?? null;
    $descriptionValue = $descriptionValue ?? '';
    $canvasWidth = $canvasWidth ?? 1024;
    $canvasHeight = $canvasHeight ?? 500;
    $canvasStyle = $canvasStyle ?? '';
    $canvasHint = $canvasHint ?? __('dental_management.odontogram.click_instruction');
    $showSaveActionButton = $showSaveActionButton ?? true;
@endphp

@if($showPatientInfo)
    @include('dental_management.odontogram.partials.patient_info', ['patient' => $patient])
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('dental_management.odontogram.odontogram_editor') }}</h3>
                <div class="card-tools">
                    @if($showLegendButton)
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#odontogram-legend-modal">
                            <i class="fas fa-info-circle"></i> {{ __('dental_management.odontogram.legend') }}
                        </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <canvas
                        id="odontogram-canvas"
                        class="odontogram-canvas"
                        width="{{ $canvasWidth }}"
                        height="{{ $canvasHeight }}"
                        @if($canvasStyle) style="{{ $canvasStyle }}" @endif
                    ></canvas>
                    @if(!empty($canvasHint))
                        <div class="mt-2">
                            <small class="text-info">{{ $canvasHint }}</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($showControls)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-lg-4 mb-3 mb-lg-0">
                            <div class="text-center">
                                <div class="mb-2">
                                    <strong>{{ __('dental_management.odontogram.selected_tooth_title') }}</strong>
                                </div>
                                <div class="odontogram-selected-tooth">
                                    <canvas id="selected-tooth-canvas" width="180" height="180" style="cursor: pointer;"></canvas>
                                </div>
                                <div class="mt-3 text-center">
                                    <div class="font-weight-bold">
                                        {{ __('dental_management.odontogram.selected_tooth_label') }}:
                                        <span id="summary-current-tooth">-</span>
                                    </div>
                                    <div class="text-muted small">
                                        {{ __('dental_management.odontogram.summary_surface') }}:
                                        <span id="summary-current-surface">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3 mb-lg-0">
                            <div class="form-group">
                                <label for="condition-selector">
                                    <i class="fas fa-tools"></i> {{ __('dental_management.treatments.singular') }}
                                </label>
                                <select class="form-control select2" id="condition-selector" onchange="setTool(this.value)">
                                    <option value="">{{ __('global.select_option') }}</option>
                                    @foreach($treatments as $treatment)
                                        @php
                                            $coverageLabel = $treatment->coverage === 'full'
                                                ? __('dental_management.treatments.coverage_full')
                                                : __('dental_management.treatments.coverage_partial');
                                        @endphp
                                        <option value="treatment_{{ $treatment->id }}">
                                            {{ $treatment->name }} ({{ $coverageLabel }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if($showSaveActionButton)
                                <button type="button" class="btn btn-success mt-2" onclick="saveCurrentAction()">
                                    <i class="fas fa-save"></i> {{ __('dental_management.odontogram.save_action') }}
                                </button>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="d-flex flex-column flex-sm-row flex-lg-column" style="gap: .5rem;">
                                <button type="button" class="btn btn-outline-secondary" onclick="clearSelectedTooth()">
                                    <i class="fas fa-times"></i> {{ __('dental_management.odontogram.clear_selection') }}
                                </button>
                                <button type="button" class="btn btn-warning" onclick="showAdvancedOptions()">
                                    <i class="fas fa-cogs"></i> {{ __('dental_management.odontogram.advanced_options') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Tratamientos registrados oculto según solicitud del usuario --}}
                    @php
                        // Sección de tratamientos registrados ocultada
                        // <div class="row mt-3">
                        //     <div class="col-12">
                        //         <div class="card h-100">
                        //             <div class="card-header d-flex justify-content-between align-items-center bg-white border-0">
                        //                 <h5 class="card-title mb-0">{{ __('dental_management.odontogram.applied_treatments') }}</h5>
                        //                 <span class="badge badge-secondary" id="summary-total-treatments">0</span>
                        //             </div>
                        //             <div class="card-body p-0">
                        //                 <div class="table-responsive" style="max-height: 260px;">
                        //                     <table class="table table-sm table-striped mb-0">
                        //                         <thead class="thead-light">
                        //                             <tr>
                        //                                 <th>{{ __('dental_management.odontogram.summary_tooth') }}</th>
                        //                                 <th>{{ __('dental_management.odontogram.summary_surface') }}</th>
                        //                                 <th>{{ __('dental_management.odontogram.summary_state') }}</th>
                        //                                 <th class="text-right">{{ __('global.actions') }}</th>
                        //                             </tr>
                        //                         </thead>
                        //                         <tbody id="treatment-summary-body"
                        //                                data-empty-text="{{ __('dental_management.odontogram.session_treatments_empty') }}"
                        //                                data-full-label="{{ __('dental_management.odontogram.full_tooth') }}">
                        //                             <tr>
                        //                                 <td colspan="4" class="text-center text-muted">
                        //                                     {{ __('dental_management.odontogram.session_treatments_empty') }}
                        //                                 </td>
                        //                             </tr>
                        //                         </tbody>
                        //                     </table>
                        //                 </div>
                        //             </div>
                        //         </div>
                        //     </div>
                        // </div>
                    @endphp

                    @if($showDoctorFields)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="doctor_id">{{ __('dental_management.odontogram.doctor') }}</label>
                                    <select id="doctor_id"
                                            name="doctor_id"
                                            class="form-control select2"
                                            {{ $doctorFieldRequired ? 'required' : '' }}>
                                        <option value="" {{ $selectedDoctorId ? '' : 'selected' }}>{{ __('global.select_option') }}</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ (string) $selectedDoctorId === (string) $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }} {{ $doctor->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">{{ __('dental_management.odontogram.description') }}</label>
                                    <textarea id="description"
                                              name="description"
                                              class="form-control"
                                              rows="2"
                                              {{ $descriptionRequired ? 'required' : '' }}>{{ $descriptionValue }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@if($showAdvancedOptions)
    @include('dental_management.odontogram.partials.advanced_options_modal', ['treatments' => $treatments])
@endif

@if($showLegendModal)
    @include('dental_management.odontogram.partials.legend_modal', ['treatments' => $treatments])
@endif

@once
    @push('scripts')
        <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Initialize select2 for doctor select
                $('#doctor_id').select2({
                    theme: 'bootstrap4',
                    placeholder: '{{ __('global.select_option') }}',
                    allowClear: false,
                    width: '100%'
                });

                // Initialize select2 for condition selector (treatments)
                $('#condition-selector').select2({
                    theme: 'bootstrap4',
                    placeholder: '{{ __('global.select_option') }}',
                    allowClear: false,
                    width: '100%'
                });
            });
        </script>
    @endpush
@endonce
