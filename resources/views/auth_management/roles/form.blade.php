<div class="row">
    <div class="col-lg-12">
        <div class="card card-info rounded">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> {{ $role->exists ? __('roles.edit_title_name', ['name' => $role->name]) : __('roles.create_title') }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">{{ __('roles.name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">{{ __('roles.description') }}</label>
                            <input type="text" name="description" id="description" value="{{ old('description', $role->description) }}" class="form-control @error('description') is-invalid @enderror">
                            @error('description')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-info rounded">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-key"></i> {{ __('roles.permissions') }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @php
                    $groupedPermissions = $permissions->groupBy(fn($p) => explode('.', $p->name)[0]);
                    $rolePermissions = $role->permissions->pluck('name')->toArray();
                @endphp

                <div class="row">
                    @foreach ($groupedPermissions as $module => $modulePermissions)
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input select-all-checkbox" id="select-all-{{ $module }}" data-module="{{ $module }}">
                                        <label class="custom-control-label font-weight-bold" for="select-all-{{ $module }}">{{ ucfirst($module) }}</label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach ($modulePermissions as $permission)
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   id="permission-{{ $permission->id }}"
                                                   value="{{ $permission->name }}"
                                                   class="custom-control-input permission-checkbox-{{ $module }}"
                                                   {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="permission-{{ $permission->id }}">{{ explode('.', $permission->name)[1] ?? $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" form="form-save" class="btn btn-primary mr-4">
                    <i class="fas fa-save"></i> {{ $role->exists ? __('global.update') : __('global.save') }}
                </button>
                <a href="{{ route('auth_management.roles.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> {{ __('global.cancel') }}
                </a>
            </div>
        </div>
    </div>
</div>
