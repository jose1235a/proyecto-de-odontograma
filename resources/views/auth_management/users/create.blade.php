@extends('layouts.app')

@section('title', __('users.create_title'))
@section('title_navbar', __('users.singular'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <h3 class="card-title"><strong><i class="fas fa-plus"></i> {{ __('global.create') }}</strong></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <form id="form-save" action="{{ route('auth_management.users.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
          @csrf          
          <div class="form-group">
            <label for="name">{{ __('users.name') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="name" id="name" class="form-control" data-parsley-minlength="3" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('users.name')]) }}">
          </div>

          <div class="form-group">
              <label for="email">{{ __('users.email') }}  <span class="text-danger">(*)</span></label>
              <input type="email" name="email" id="email" class="form-control" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('users.email')]) }}">
          </div>

          <div class="form-group">
            <label for="password">{{ __('users.password') }}  <span class="text-danger">(*)</span></label>
            <input type="password" name="password" id="password" class="form-control" required placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('users.password')]) }}" >
          </div>

          <div class="form-group">
              <label for="photo">{{ __('users.photo') }} </label>
              <input type="file" name="photo" class="form-control">
          </div>

          <div class="form-group">
            <label for="role">{{ __('users.role') }} <span class="text-danger">(*)</span></label>
            <select name="role" id="role" class="form-control" required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>
                    {{ __('global.select_option') }}
                </option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
          </div>
        </form>
      </div>
      
      <div class="card-footer text-center">
        <a href="{{ route('auth_management.users.index') }}" class="btn btn-secondary mr-2">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
        <button type="button" onclick="submitWithParsley()" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ __('global.save') }}
        </button>
      </div>
      
    </div>
  </div>
</div>
@endsection
