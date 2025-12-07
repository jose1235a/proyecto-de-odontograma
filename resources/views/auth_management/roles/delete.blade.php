@extends('layouts.app')

@section('title', __('roles.delete_title'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><strong><i class="fas fa-trash"></i> {{ __('roles.delete_title') }}</strong></h3>
            </div>
            <div class="card-body">
                <p>{{ __('roles.delete_confirmation', ['role' => $role->name]) }}</p>

            </div>
            <div class="card-footer text-center">
                <form action="{{ route('auth_management.roles.destroy', $role) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('auth_management.roles.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-times"></i> {{ __('global.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> {{ __('global.yes_delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
