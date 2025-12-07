@extends('layouts.app')

@section('title', __('dental_management.payments.delete_title'))
@section('title_navbar', __('dental_management.payments.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-danger rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-trash"></i> {{ __('dental_management.payments.delete_title') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="alert alert-warning">
          <h5><i class="icon fas fa-exclamation-triangle"></i> {{ __('global.warning') }}!</h5>
          {{ __('dental_management.payments.delete_warning') }}
        </div>

        <div class="row">
          <div class="col-md-6">
            <dl class="row">
              <dt class="col-sm-4">{{ __('dental_management.payments.fields.patient') }}:</dt>
              <dd class="col-sm-8">{{ $payment->patient->name ?? '-' }}</dd>

              <dt class="col-sm-4">{{ __('dental_management.payments.fields.amount') }}:</dt>
              <dd class="col-sm-8">S/ {{ number_format($payment->amount, 2) }}</dd>

              <dt class="col-sm-4">{{ __('dental_management.payments.fields.payment_date') }}:</dt>
              <dd class="col-sm-8">{{ $payment->payment_date->format('d/m/Y') }}</dd>
            </dl>
          </div>
          <div class="col-md-6">
            <dl class="row">
              <dt class="col-sm-4">{{ __('dental_management.payments.fields.payment_method') }}:</dt>
              <dd class="col-sm-8">{!! $payment->payment_method_html !!}</dd>

              <dt class="col-sm-4">{{ __('dental_management.payments.fields.status') }}:</dt>
              <dd class="col-sm-8">{!! $payment->status_html !!}</dd>
            </dl>
          </div>
        </div>

        @include('dental_management.payments.partials.form_delete', ['returnUrl' => $returnUrl ?? null])
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-delete" class="btn btn-danger mr-4">
          <i class="fas fa-trash"></i> {{ __('global.delete') }}
        </button>
        <a href="{{ $backUrl ?? route('dental_management.payments.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> {{ __('global.cancel') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@include('dental_management.payments.partials.scripts')
@endpush