@extends('layouts.app')

@section('title', __('dental_management.odontogram.create_title'))
@section('title_navbar', __('dental_management.odontogram.plural'))

@section('content')
@include('dental_management.odontogram.partials.patient_conditions_alert', ['patient' => $patient])

<div class="row">
    <div class="col-lg-12">
        <div class="card card-info rounded">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tooth"></i> {{ __('dental_management.odontogram.create_title') }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ $backUrl }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
                        </a>
                    </div>
                </div>

            <form action="{{ route('dental_management.odontogram.store') }}" method="POST" id="odontogram-form">
                        @csrf
                        @include('dental_management.odontogram.partials.form_setup', [
                            'formIdentifier' => 'odontogram_create',
                            'selectedDoctorId' => null,
                            'descriptionValue' => ''
                        ])

                        @include('dental_management.odontogram.partials.editor_workspace', [
                            'patient' => $patient ?? null,
                            'treatments' => $treatments,
                            'doctors' => $doctors,
                            'doctorFieldRequired' => true,
                            'descriptionRequired' => true,
                            'selectedDoctorId' => $selectedDoctorId,
                            'descriptionValue' => $descriptionValue,
                            'showSaveActionButton' => false,
                        ])
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary mr-4">
                        <i class="fas fa-save"></i> {{ __('global.save') }}
                    </button>
                    <a href="{{ $backUrl }}" class="btn btn-default">
                        <i class="fas fa-times"></i> {{ __('global.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('dental_management.odontogram.partials.create_scripts', ['initialData' => [], 'odontogram' => null])
@endpush
