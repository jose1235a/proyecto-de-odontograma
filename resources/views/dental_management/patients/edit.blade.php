@extends('layouts.app')

@section('title', __('dental_management.patients.edit_title'))
@section('title_navbar', __('dental_management.patients.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-edit"></i> {{ __('global.edit') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('dental_management.patients.partials.form_edit')
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> {{ __('global.update') }}
        </button>
        <a href="{{ route('dental_management.patients.index') }}" class="btn btn-default">
          <i class="fas fa-times"></i> {{ __('global.cancel') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#document').on('blur', function() {
        if ($('#document_type').val() === 'dni') {
            var dni = $(this).val().trim();
            if (dni.length === 8 && /^\d+$/.test(dni)) {
                $.ajax({
                    url: '{{ route("dental_management.patients.dni.lookup") }}',
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

// Medical history description toggle
$(document).ready(function() {
    $('.medical-select').on('change', function() {
        var selectId = $(this).attr('id');
        var descriptionId = selectId + '_description';
        var descriptionField = $('#' + descriptionId);

        if ($(this).val() == '1') {
            descriptionField.show();
        } else {
            descriptionField.hide();
            descriptionField.val(''); // Clear the value when hidden
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