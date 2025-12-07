@extends('layouts.app')

@section('title', __('dental_management.odontogram.title'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dental_management.odontogram.title') }}</h3>
                </div>

                <div class="card-body">
                    @include('dental_management.odontogram.partials.index_filters', [
                        'patients' => $patients,
                        'doctors' => $doctors,
                    ])

                    @include('dental_management.odontogram.partials.index_results')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('dental_management.odontogram.partials.scripts')
@endpush
