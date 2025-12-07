@extends('layouts.app')

@section('title', __('dental_management.odontogram.title'))

@section('content')
@php
    $patient = $odontogram->patient;
@endphp
@include('dental_management.odontogram.partials.patient_conditions_alert', ['patient' => $patient])

<div class="row">
    <div class="col-lg-12">
        <div class="card card-info rounded">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dental_management.odontogram.patient_odontogram_title') }}</h3>
                    <div class="card-tools">
                        <a href="{{ $backUrl }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
                        </a>
                    </div>
                </div>

                <form action="{{ route('dental_management.odontogram.update', $odontogram) }}" method="POST" id="odontogram-form">
                    @csrf
                    @method('PUT')
                    @if(!empty($returnUrl))
                        <input type="hidden" name="return_url" value="{{ $returnUrl }}">
                    @endif
                    <input type="hidden" name="form_identifier" value="odontogram_edit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h3 class="card-title mb-0">
                                            <i class="fas fa-history"></i> {{ __('dental_management.odontogram.history_title') }}
                                        </h3>
                                        <span class="badge badge-secondary" id="history-count-badge">{{ $histories->count() }}</span>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive" style="max-height: 520px;">
                                            <table class="table table-sm table-hover mb-0" id="odontogram-history-table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>{{ __('dental_management.odontogram.history_registered') }}</th>
                                                        <th>{{ __('dental_management.odontogram.history_description') }}</th>
                                                        <th>{{ __('dental_management.odontogram.doctor') }}</th>
                                                        <th class="text-center">{{ __('global.actions') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody data-empty-text="{{ __('global.no_records') }}">
                                                    @forelse($histories as $history)
                                                        <tr class="{{ optional($activeHistory)->id === $history->id ? 'table-info' : '' }}"
                                                            data-history-row="{{ $history->id }}">
                                                            <td data-column="registered">{{ optional($history->date_procedure ?? $history->created_at)->format('d/m/Y H:i') }}</td>
                                                            <td data-column="description">{{ \Illuminate\Support\Str::limit($history->description, 40) }}</td>
                                                            <td data-column="doctor">{{ trim(($history->doctor->name ?? '') . ' ' . ($history->doctor->last_name ?? '')) ?: '-' }}</td>
                                                            <td class="text-center">
                                                                <div class="btn-group btn-group-sm">
                                                                    <button type="button"
                                                                            class="btn btn-outline-primary load-history"
                                                                            data-history='@json($history->cumulative_canvas_data ?? $history->canvas_data)'
                                                                            data-history-id="{{ $history->id }}">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-outline-warning edit-history"
                                                                            data-update-url="{{ route('dental_management.odontogram_histories.update', $history) }}"
                                                                            data-history-id="{{ $history->id }}"
                                                                            data-doctor-id="{{ $history->doctor_id }}"
                                                                            data-description="{{ e($history->description) }}">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-outline-danger delete-history"
                                                                            data-delete-url="{{ route('dental_management.odontogram_histories.destroy', $history) }}"
                                                                            data-history-id="{{ $history->id }}">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
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
                        <input type="hidden" name="patient_id" value="{{ $odontogram->patient_id }}">
                        <input type="hidden" name="is_active" value="1">

                        @php
                            $formIdentifier = 'odontogram_edit';
                            $shouldPrefillForm = old('form_identifier') === $formIdentifier;
                            $editorSelectedDoctorId = $shouldPrefillForm ? old('doctor_id') : null;
                            $editorDescriptionValue = $shouldPrefillForm ? old('description') : '';
                        @endphp

                        @include('dental_management.odontogram.partials.form_setup', [
                            'formIdentifier' => $formIdentifier,
                            'selectedDoctorId' => $editorSelectedDoctorId,
                            'descriptionValue' => $editorDescriptionValue,
                        ])

                        @include('dental_management.odontogram.partials.editor_workspace', [
                            'patient' => $patient ?? null,
                            'treatments' => $treatments,
                            'doctors' => $doctors,
                            'selectedDoctorId' => $editorSelectedDoctorId,
                            'descriptionValue' => $editorDescriptionValue,
                            'canvasWidth' => 750,
                            'canvasHeight' => 400,
                        ])

                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-success mr-4" id="update-odontogram-btn">
                            <i class="fas fa-save"></i> {{ __('global.update') }}
                        </button>
                        <a href="{{ $backUrl }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> {{ __('global.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editHistoryModal" tabindex="-1" role="dialog" aria-labelledby="editHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHistoryModalLabel">
                    <i class="fas fa-edit"></i> {{ __('dental_management.odontogram.history_edit_title') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('global.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-history-form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="edit-history-doctor">{{ __('dental_management.odontogram.history_edit_doctor') }}</label>
                                <select name="doctor_id" id="edit-history-doctor" class="form-control select2 w-100">
                                    <option value="">{{ __('global.select_option') }}</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }} {{ $doctor->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="edit-history-description">{{ __('dental_management.odontogram.history_edit_description') }}</label>
                                <textarea name="description" id="edit-history-description" class="form-control" rows="4" required maxlength="1000"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('global.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('global.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/select2/js/i18n/es.js') }}"></script>
@include('dental_management.odontogram.partials.create_scripts', ['initialData' => $initialData, 'odontogram' => $odontogram])
@include('dental_management.odontogram.partials.history_scripts')
@endpush
