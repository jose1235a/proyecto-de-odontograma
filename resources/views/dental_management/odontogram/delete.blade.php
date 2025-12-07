@extends('layouts.app')

@section('title', __('dental_management.odontogram.delete_title'))
@section('title_navbar', __('dental_management.odontogram.plural'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-danger rounded">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dental_management.odontogram.delete_title') }}</h3>
                    <div class="card-tools">
                        <a href="{{ $backUrl }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Warning Message -->
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> {{ __('global.warning') }}</h5>
                        {{ __('global.warning_delete') }}
                    </div>

                    <!-- Odontogram Information -->
                    @php
                        $latestHistory = $odontogram->latestHistory;
                    @endphp

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
                                <p class="form-control-plaintext">{{ optional($latestHistory?->doctor)->name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
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
                                <p class="form-control-plaintext">{{ $latestHistory->description ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Form -->
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('dental_management.odontogram.deleteSave', $odontogram) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                @if(!empty($returnUrl))
                                    <input type="hidden" name="return_url" value="{{ $returnUrl }}">
                                @endif

                                <div class="form-group">
                                    <label for="reason">{{ __('global.delete_description') }} <span class="text-danger">*</span></label>
                                    <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror"
                                              rows="3" placeholder="{{ __('global.delete_reason_placeholder') }}" required></textarea>
                                    @error('reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('global.are_you_sure') }}</small>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-danger mr-4">
                                        <i class="fas fa-trash"></i> {{ __('global.yes_delete') }}
                                    </button>
                                    <a href="{{ $backUrl }}" class="btn btn-default">
                                        <i class="fas fa-times"></i> {{ __('global.cancel') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
