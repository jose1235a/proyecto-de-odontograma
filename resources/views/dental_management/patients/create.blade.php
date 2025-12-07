@extends('layouts.app')

@section('title', __('dental_management.patients.create'))
@section('title_navbar', __('dental_management.patients.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-plus"></i> {{ __('global.create') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('dental_management.patients.partials.form_create')
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> {{ __('global.save') }}
        </button>
        <a href="{{ route('dental_management.patients.index') }}" class="btn btn-default">
          <i class="fas fa-times"></i> {{ __('global.cancel') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.select2-container--bootstrap4 .select2-selection--single {
    border-color: #ced4da;
}
.select2-container--bootstrap4 .select2-selection--single:hover {
    border-color: #adb5bd;
}
.select2-container--bootstrap4.select2-container--focus .select2-selection--single {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Ensure Select2 dropdown opens downward */
.select2-container--bootstrap4 .select2-dropdown {
    border-color: #ced4da;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.select2-container--bootstrap4 .select2-results__option--highlighted {
    background-color: #007bff;
    color: white;
}

.select2-container--bootstrap4 .select2-selection__clear {
    color: #6c757d;
    cursor: pointer;
    float: right;
    font-weight: bold;
    margin-right: 30px;
}
</style>
@endpush

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<script>
$(document).ready(function() {
    $('#document').on('blur', function() {
        // Solo procesar si el tipo de documento es DNI
        if ($('#document_type').val() === 'dni') {
            var dni = $(this).val().trim();

            // Validar formato del DNI
            if (dni.length === 8 && /^\d+$/.test(dni)) {
                // Petición AJAX al endpoint de pacientes
                $.ajax({
                    url: '{{ route("dental_management.patients.dni.lookup") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        dni: dni
                    },
                    success: function(response) {
                        if (response.success) {
                            // Autocompletar campos
                            $('#name').val(response.name);
                            $('#last_name').val(response.last_name);
                        } else {
                            // Log silencioso de errores
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

// Medical history description toggle - Only for specific fields
$(document).ready(function() {
    // Fields that should show description when "Yes" is selected
    var fieldsWithDescription = ['under_medical_treatment', 'allergic_to_medication'];

    $('.medical-select').on('change', function() {
        var selectId = $(this).attr('id');
        var descriptionId = selectId + '_description';
        var descriptionField = $('#' + descriptionId);

        // Only show description for specific fields
        if (fieldsWithDescription.includes(selectId)) {
            if ($(this).val() == '1') {
                descriptionField.show();
            } else {
                descriptionField.hide();
                descriptionField.val(''); // Clear the value when hidden
            }
        }
    });

    // Gender change to show/hide pregnant option
    $('#gender').on('change', function() {
        var pregnantDiv = $('#pregnant').closest('.col-md-4');
        if ($(this).val() == 'M') {
            pregnantDiv.hide();
            $('#pregnant').val('').trigger('change'); // Reset and trigger change
        } else if ($(this).val() == 'F') {
            pregnantDiv.show();
        } else {
            pregnantDiv.show(); // Show if no gender selected
        }
    });

    // Trigger change on page load to show descriptions if already selected
    $('.medical-select').trigger('change');
    $('#gender').trigger('change');

    // Auto-fill consultation cost when treatment is selected
    $('#treatment_id').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var cost = selectedOption.data('cost');

        if (cost !== undefined && cost !== '') {
            $('#consultation_cost').val(parseFloat(cost).toFixed(2));
        } else {
            $('#consultation_cost').val('0.00');
        }
    });

    // Trigger change on page load to set initial cost if treatment is pre-selected
    $('#treatment_id').trigger('change');

    // Initialize select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '{{ __("global.select_option") }}',
        width: '100%',
        dropdownParent: $('.modal-body, .card-body, body').first(),
        dropdownAutoWidth: true
    });
});

// Camera functionality for patient photos
$(document).ready(function() {
    let stream = null;
    let canvas = document.getElementById('photo-canvas');
    let video = document.getElementById('camera-preview');

    // Take photo button
    $('#take-photo-btn').on('click', function() {
        $('#camera-container').show();
        startCamera();
    });

    // Cancel camera
    $('#cancel-camera-btn').on('click', function() {
        stopCamera();
        $('#camera-container').hide();
    });

    // Capture photo
    $('#capture-btn').on('click', function() {
        capturePhoto();
    });

    // File input change (when user selects a file)
    $('#photo').on('change', function() {
        // Hide camera if it's open
        stopCamera();
        $('#camera-container').hide();
    });

    function startCamera() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(mediaStream) {
                stream = mediaStream;
                video.srcObject = mediaStream;
            })
            .catch(function(err) {
                alert('Error accessing camera: ' + err.message);
                $('#camera-container').hide();
            });
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
    }

    function capturePhoto() {
        let context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert canvas to blob and create file input
        canvas.toBlob(function(blob) {
            let file = new File([blob], 'photo_' + Date.now() + '.jpg', { type: 'image/jpeg' });

            // Create DataTransfer to set the file
            let dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('photo').files = dt.files;

            // Stop camera and hide container
            stopCamera();
            $('#camera-container').hide();

            // Show success message
            alert('Foto capturada exitosamente');
        }, 'image/jpeg', 0.8);
    }
});
</script>
@endpush