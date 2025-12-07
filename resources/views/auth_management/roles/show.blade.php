@extends('layouts.app')

@section('title', __('roles.show_title_name', ['name' => $role->name]))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-light border-bottom font-weight-bold">
                <i class="fas fa-eye"></i> {{ __('roles.show_title_name', ['name' => $role->name]) }}
            </div>
            <div class="card-body">
                <p><strong>{{ __('roles.name') }}:</strong> {{ $role->name }}</p>
                <p><strong>{{ __('roles.description') }}:</strong> {{ $role->description }}</p>
                <hr>
                <h5>{{ __('roles.assigned_permissions') }}</h5>
                @if($role->permissions->count() > 0)
                    <div class="row">
                        @foreach($role->permissions->sortBy('name')->groupBy(fn($p) => explode('.', $p->name)[0]) as $module => $permissions)
                            <div class="col-md-4">
                                <strong>{{ ucfirst($module) }}</strong>
                                <ul class="list-unstyled ml-3">
                                    @foreach($permissions as $permission)
                                        <li><i class="fas fa-check-circle text-success"></i> {{ explode('.', $permission->name)[1] ?? $permission->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>{{ __('roles.no_permissions_assigned') }}</p>
                @endif
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('auth_management.roles.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
                </a>
                @can('roles.edit')
                <a href="{{ route('auth_management.roles.edit', $role) }}" class="btn btn-primary">
                    <i class="fas fa-pen"></i> {{ __('global.edit') }}
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
