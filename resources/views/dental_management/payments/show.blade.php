@extends('layouts.app')

@section('title', __('dental_management.payments.show_title'))
@section('title_navbar', __('dental_management.payments.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-eye"></i> {{ __('dental_management.payments.show_title') }}
        </h3>
        <div class="card-tools">
          <a href="{{ route('dental_management.payments.edit', $payment->slug) }}?return_url={{ urlencode($returnUrl ?? request()->fullUrl()) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-pen"></i> {{ __('global.edit') }}
          </a>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <dl class="row">
              <dt class="col-sm-4">{{ __('dental_management.payments.fields.patient') }}:</dt>
              <dd class="col-sm-8">{{ $payment->patient->name ?? '-' }}</dd>

              <dt class="col-sm-4">{{ __('dental_management.payments.fields.amount') }}:</dt>
              <dd class="col-sm-8">S/ {{ number_format($payment->amount, 2) }}</dd>

              <dt class="col-sm-4">{{ __('dental_management.payments.fields.payment_date') }}:</dt>
              <dd class="col-sm-8">{{ $payment->payment_date->format('d/m/Y') }}</dd>

              <dt class="col-sm-4">{{ __('dental_management.payments.fields.payment_method') }}:</dt>
              <dd class="col-sm-8">{!! $payment->payment_method_html !!}</dd>
            </dl>
          </div>
          <div class="col-md-6">
            <dl class="row">
              <dt class="col-sm-4">{{ __('dental_management.payments.fields.status') }}:</dt>
              <dd class="col-sm-8">{!! $payment->status_html !!}</dd>

              <dt class="col-sm-4">{{ __('dental_management.payments.fields.reference_number') }}:</dt>
              <dd class="col-sm-8">{{ $payment->reference_number ?? '-' }}</dd>

              <dt class="col-sm-4">{{ __('dental_management.payments.fields.appointment') }}:</dt>
              <dd class="col-sm-8">{{ $payment->appointment->treatment->name ?? '-' }}</dd>

              <dt class="col-sm-4">{{ __('global.created_at') }}:</dt>
              <dd class="col-sm-8">{{ $payment->created_at->format('d/m/Y H:i') }}</dd>
            </dl>
          </div>
        </div>

        @if($payment->notes)
        <div class="row">
          <div class="col-12">
            <dt>{{ __('dental_management.payments.fields.notes') }}:</dt>
            <dd>{{ $payment->notes }}</dd>
          </div>
        </div>
        @endif
      </div>
      <div class="card-footer text-center">
        <a href="{{ $returnUrl ?? route('dental_management.payments.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection