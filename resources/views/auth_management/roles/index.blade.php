@extends('layouts.app')

@section('title', __('roles.index_title'))
@section('title_navbar', __('roles.title'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-info rounded">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter"></i> {{ __('global.card_title_filter') }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="search">{{ __('global.search') }}</label>
                            <input type="text" id="search" name="search" class="form-control" placeholder="{{ __('roles.search_placeholder') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="button" class="btn btn-primary mr-4">
                    <i class="fas fa-search"></i> {{ __('global.search') }}
                </button>
                <a href="{{ route('auth_management.roles.index') }}" class="btn btn-default">
                    <i class="fas fa-brush"></i> {{ __('global.clear') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-info rounded">
            <div class="card-header">
                <h3 class="card-title pt-1">
                    <i class="fas fa-table"></i> {{ __('global.card_title_result') }}: {{ count($roles) }}
                </h3>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary mr-2" href="{{ route('auth_management.roles.create') }}">
                        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }}</span>
                    </a>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>{{ __('roles.name') }}</th>
                                <th>{{ __('roles.description') }}</th>
                                <th class="text-center">{{ __('global.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @can('roles.view')
                                            <a class="btn btn-light" href="{{ route('auth_management.roles.show', $role) }}" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can('roles.edit')
                                            <a class="btn btn-light" href="{{ route('auth_management.roles.edit', $role) }}" title="Editar">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @endcan
                                            @can('roles.delete')
                                                @if($role->name !== 'super')
                                                <a class="btn btn-light" href="{{ route('auth_management.roles.delete', $role) }}" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection