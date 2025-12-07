@extends('layouts.app')

@section('title', 'Usuario - Editar')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-light border-bottom font-weight-bold">
        <i class="fas fa-pen"></i> Editar Registro
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
 
      <div class="card-body">
        <form id="form-save" action="{{ route('auth_management.users.update', $user) }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
          @csrf
          @method('PUT')   
          <div class="form-group">
            <label for="name">Nombre <span class="text-danger">(*)</span></label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $user->name) }}" 
                   class="form-control" required>
          </div>

          <div class="form-group">
            <label for="email">Email <span class="text-danger">(*)</span></label>
            <input type="email" name="email" id="email" 
                   value="{{ old('email', $user->email) }}" 
                   class="form-control" required>
          </div>

          <div class="form-group">
            <label for="password">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" id="password" 
                   class="form-control" placeholder="Dejar en blanco si no desea cambiarla">
          </div>

          <div class="form-group">
              <label for="photo">Foto</label>
              <input type="file" name="photo" class="form-control">
          </div>  
          
          <div class="form-group">
            <label for="is_active">Estado <span class="text-danger">(*)</span></label>
            <select name="is_active" id="is_active" class="form-control" required>
              <option value="1" {{ old('is_active', $user->is_active) == '1' ? 'selected' : '' }}>Activo</option>
              <option value="0" {{ old('is_active', $user->is_active) == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
          </div>

          <div class="form-group">
            <label for="role">{{ __('users.role') }} <span class="text-danger">(*)</span></label>
            @php
                $currentRole = old('role', $user->roles->pluck('name')->first());
            @endphp
            <select name="role" id="role" class="form-control" required>
                <option value="">{{ __('global.select_option') }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $currentRole === $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
          </div>

        </form>  
      </div>

      <div class="card-footer text-center">
        <a href="{{ route('auth_management.users.index') }}" class="btn btn-secondary mr-2">
          <i class="fas fa-arrow-left"></i> Regresar
        </a>
        <button type="submit"  onclick="document.getElementById('form-save').submit();" class="btn btn-primary">
          <i class="fas fa-save"></i> Actualizar Datos
        </button>
      </div>
      
    </div>
  </div>
</div>
@endsection
