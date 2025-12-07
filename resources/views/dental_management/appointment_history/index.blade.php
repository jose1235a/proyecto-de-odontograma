@extends('layouts.app')

@section('title', __('dental_management.appointment_history.title'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dental_management.appointment_history.title') }}</h3>
                </div>

                <div class="card-body">
                    @include('dental_management.appointment_history.partials.index_filters')

                    @include('dental_management.appointment_history.partials.index_results')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('dental_management.appointment_history.partials.scripts')
@endpush