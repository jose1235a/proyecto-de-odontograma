@extends('layouts.app')

@section('title', __('dental_management.doctors.create_title'))
@section('title_navbar', __('dental_management.doctors.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-plus"></i> {{ __('dental_management.doctors.create') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('dental_management.doctors.partials.form_create')
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> {{ __('global.save') }}
        </button>
        <a href="{{ route('dental_management.doctors.index') }}" class="btn btn-default">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@include('dental_management.doctors.partials.scripts')
<script>
$(document).ready(function() {
    $('#document').on('blur', function() {
        if ($('#document_type').val() === 'dni') {
            var dni = $(this).val().trim();
            if (dni.length === 8 && /^\d+$/.test(dni)) {
                $.ajax({
                    url: '{{ route("dental_management.doctors.dni.lookup") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        dni: dni
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#name').val(response.name);
                            $('#last_name').val(response.last_name);
                        } else {
                            console.log(response.message || 'No se encontraron datos.');
                        }
                    },
                    error: function() {
                        console.log('Error al consultar el DNI.');
                    }
                });
            }
        }
    });
});
</script>
@endpush