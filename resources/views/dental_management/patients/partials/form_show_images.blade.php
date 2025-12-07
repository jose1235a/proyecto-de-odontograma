
<div class="mb-3">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addImageModal">
    <i class="fas fa-plus"></i> {{ __('dental_management.patients.upload_image') }}
  </button>
</div>

<!-- Modal para agregar imagen -->
<div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addImageModalLabel">
          <i class="fas fa-image"></i> {{ __('dental_management.patient_images.create') }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="image-form" action="{{ route('dental_management.patient_images.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
        <div class="modal-body">
          <!-- Paciente (solo lectura) -->
          <div class="form-group">
            <label>{{ __('dental_management.patient_images.patient_id') }}</label>
            <input type="text" class="form-control" value="{{ $patient->name }} {{ $patient->last_name }}" readonly>
          </div>

          <!-- Título e Imagen en fila -->
          <div class="row">
            <div class="col-md-6">
              <!-- Título -->
              <div class="form-group">
                <label for="title">{{ __('dental_management.patient_images.fields.title') }} <span class="text-danger">(*)</span></label>
                <input type="text" name="title" id="title" class="form-control" required
                       placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patient_images.title')]) }}">
              </div>
            </div>
            <div class="col-md-6">
              <!-- Opciones de imagen -->
              <div class="form-group">
                <label>{{ __('dental_management.patient_images.image') }} <span class="text-danger">(*)</span></label>
                <div class="mb-2">
                  <button type="button" class="btn btn-outline-primary btn-sm" id="upload-image-btn">
                    <i class="fas fa-upload"></i> {{ __('dental_management.patients.upload_image') }}
                  </button>
                  <button type="button" class="btn btn-outline-success btn-sm" id="take-photo-btn">
                    <i class="fas fa-camera"></i> {{ __('dental_management.patients.take_photo') }}
                  </button>
                </div>

                <!-- Input file oculto -->
                <input type="file" name="image" id="image-input" accept="image/*" style="display: none;">

                <!-- Elementos para tomar foto -->
                <div id="camera-container" style="display: none;">
                  <video id="camera" style="width: 100%; max-width: 400px; border: 1px solid #ddd;"></video>
                  <button type="button" class="btn btn-warning btn-sm mt-2" id="capture-btn" style="display: none;">
                    <i class="fas fa-camera"></i> Capturar Foto
                  </button>
                </div>
                <canvas id="canvas" style="display: none;"></canvas>

                <!-- Preview de imagen -->
                <div id="image-preview" class="mt-2" style="display: none;">
                  <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                </div>
              </div>
            </div>
          </div>

          <!-- Descripción -->
          <div class="form-group">
            <label for="description">{{ __('dental_management.patient_images.fields.description') }}</label>
            <textarea name="description" id="description" class="form-control" rows="3"
                      placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patient_images.description')]) }}"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i> {{ __('global.cancel') }}
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ __('global.save') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para editar imagen -->
<div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="editImageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editImageModalLabel">
          <i class="fas fa-edit"></i> {{ __('dental_management.patient_images.edit') }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="edit-image-form" action="" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <!-- Paciente (solo lectura) -->
          <div class="form-group">
            <label>{{ __('dental_management.patient_images.patient_id') }}</label>
            <input type="text" class="form-control" value="{{ $patient->name }} {{ $patient->last_name }}" readonly>
          </div>

          <!-- Imagen actual y Nueva imagen en fila -->
          <div class="row">
            <div class="col-md-6">
              <!-- Imagen actual -->
              <div class="form-group">
                <label>{{ __('dental_management.patient_images.current_image') }}</label>
                <div id="current-image-preview" class="mt-2" style="display: none;">
                  <img id="current-preview-img" src="" alt="Imagen actual" class="img-thumbnail" style="max-height: 200px;">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <!-- Nueva imagen (opcional) -->
              <div class="form-group">
                <label>{{ __('dental_management.patient_images.new_image_optional') }}</label>
                <div class="mb-2">
                  <button type="button" class="btn btn-outline-primary btn-sm" id="edit-upload-image-btn">
                    <i class="fas fa-upload"></i> {{ __('dental_management.patients.upload_image') }}
                  </button>
                  <button type="button" class="btn btn-outline-success btn-sm" id="edit-take-photo-btn">
                    <i class="fas fa-camera"></i> {{ __('dental_management.patients.take_photo') }}
                  </button>
                </div>

                <!-- Input file oculto -->
                <input type="file" name="image" id="edit-image-input" accept="image/*" style="display: none;">

                <!-- Elementos para tomar foto -->
                <div id="edit-camera-container" style="display: none;">
                  <video id="edit-camera" style="width: 100%; max-width: 400px; border: 1px solid #ddd;"></video>
                  <button type="button" class="btn btn-warning btn-sm mt-2" id="edit-capture-btn" style="display: none;">
                    <i class="fas fa-camera"></i> Capturar Foto
                  </button>
                </div>
                <canvas id="edit-canvas" style="display: none;"></canvas>

                <!-- Preview de nueva imagen -->
                <div id="edit-image-preview" class="mt-2" style="display: none;">
                  <img id="edit-preview-img" src="" alt="Nueva imagen" class="img-thumbnail" style="max-height: 200px;">
                </div>
              </div>
            </div>
          </div>

          <!-- Título -->
          <div class="form-group">
            <label for="edit_title">{{ __('dental_management.patient_images.fields.title') }} <span class="text-danger">(*)</span></label>
            <input type="text" name="title" id="edit_title" class="form-control" required
                   placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patient_images.title')]) }}">
          </div>

          <!-- Descripción -->
          <div class="form-group">
            <label for="edit_description">{{ __('dental_management.patient_images.fields.description') }}</label>
            <textarea name="description" id="edit_description" class="form-control" rows="3"
                      placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patient_images.description')]) }}"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i> {{ __('global.cancel') }}
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ __('global.save') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@php
    $activeImages = $patient->patientImages
        ? $patient->patientImages->where('is_active', true)->sortBy('created_at')
        : collect();
@endphp

@if($activeImages->count() > 0)
  <div class="table-responsive">
    <table class="table table-bordered table-striped" id="patient-images-table">
      <thead>
        <tr>
          <th>{{ __('dental_management.patient_images.fields.date') }}</th>
          <th>{{ __('dental_management.patient_images.fields.title') }}</th>
          <th>{{ __('dental_management.patient_images.fields.description') }}</th>
          <th>{{ __('dental_management.patient_images.image') }}</th>
          <th>{{ __('global.actions') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($activeImages as $patientImage)
          <tr>
            <td data-order="{{ $patientImage->created_at->timestamp }}">
              {{ $patientImage->created_at->format('d/m/Y H:i') }}
            </td>
            <td>{{ $patientImage->title }}</td>
            <td>{{ $patientImage->description ? Str::limit($patientImage->description, 120) : '-' }}</td>
            <td>
              <img src="{{ $patientImage->image_url }}" alt="{{ $patientImage->title }}" style="height: 80px; width: 80px; object-fit: cover; border-radius: 6px;">
            </td>
            <td>
              <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-info view-image" data-image="{{ $patientImage->image_url }}" data-title="{{ $patientImage->title }}" data-description="{{ $patientImage->description }}" data-date="{{ $patientImage->created_at->format('d/m/Y H:i') }}">
                  <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-outline-warning edit-image" data-id="{{ $patientImage->id }}" data-slug="{{ $patientImage->slug }}" data-title="{{ $patientImage->title }}" data-description="{{ $patientImage->description }}" data-image="{{ $patientImage->image_url }}">
                  <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-outline-danger delete-image" data-id="{{ $patientImage->id }}" data-slug="{{ $patientImage->slug }}" data-title="{{ $patientImage->title }}">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@else
  <div class="alert alert-info">
    <i class="fas fa-info-circle"></i> {{ __('dental_management.patient_images.no_images') }}
  </div>
@endif

<!-- Modal para ver imagen -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Imagen del paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8 text-center">
            <img id="modalImage" src="" alt="Imagen del paciente" class="img-fluid" style="max-height: 70vh;">
          </div>
          <div class="col-md-4">
            <div class="mb-2">
              <strong class="text-dark">
                <i class="fas fa-calendar"></i> <span id="modalImageDate"></span>
              </strong>
            </div>
            <h6 id="modalImageTitle" class="font-weight-bold mb-2 text-muted"></h6>
            <p id="modalImageDescription" class="text-muted"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('global.cancel') }}</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para eliminar imagen -->
<div class="modal fade" id="deleteImageModal" tabindex="-1" role="dialog" aria-labelledby="deleteImageModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteImageModalLabel">
          <i class="fas fa-trash text-danger"></i> {{ __('global.confirm_delete') }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteImageForm">
        @csrf
        @method('DELETE')
        <div class="modal-body">
          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>{{ __('global.attention') }}:</strong> {{ __('global.confirm_delete_text') }}
          </div>

          <div class="form-group">
            <label for="delete_reason" class="font-weight-bold">
              {{ __('dental_management.patient_images.fields.delete_reason') }} <span class="text-danger">(*)</span>
            </label>
            <textarea
              name="reason"
              id="delete_reason"
              class="form-control"
              rows="3"
              placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patient_images.fields.delete_reason')]) }}"
              required
              minlength="10"
              maxlength="500"></textarea>
            <small class="form-text text-muted">
              {{ __('global.min_characters', ['count' => 10]) }} - {{ __('global.max_characters', ['count' => 500]) }}
            </small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i> {{ __('global.cancel') }}
          </button>
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> {{ __('global.yes_delete') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let stream;
    let patientId = {{ $patient->id }};
    let selectedFile = null;
    let editSelectedFile = null;

    // Modal de agregar imagen
    const uploadBtn = document.getElementById('upload-image-btn');
    const takePhotoBtn = document.getElementById('take-photo-btn');
    const imageInput = document.getElementById('image-input');
    const imageForm = document.getElementById('image-form');

    // Modal de editar imagen
    const editUploadBtn = document.getElementById('edit-upload-image-btn');
    const editTakePhotoBtn = document.getElementById('edit-take-photo-btn');
    const editImageInput = document.getElementById('edit-image-input');
    const editImageForm = document.getElementById('edit-image-form');

    // Variable para almacenar el stream de la cámara de edición
    let editStream = null;

    if (uploadBtn) {
        uploadBtn.addEventListener('click', function() {
            if (imageInput) {
                imageInput.click();
            }
        });
    }

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                selectedFile = file;
                showImagePreview(file);
            }
        });
    }

    if (takePhotoBtn) {
        takePhotoBtn.addEventListener('click', function() {
            startCamera();
        });
    }

    // Modal de editar imagen
    if (editUploadBtn) {
        editUploadBtn.addEventListener('click', function() {
            if (editImageInput) {
                editImageInput.click();
            }
        });
    }

    if (editImageInput) {
        editImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                editSelectedFile = file;
                showEditImagePreview(file);
            }
        });
    }

    if (editTakePhotoBtn) {
        editTakePhotoBtn.addEventListener('click', function() {
            startEditCamera();
        });
    }

    // Formulario de imagen
    if (imageForm) {
        imageForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!selectedFile) {
                Swal.fire({
                    title: '{{ __("global.error") }}',
                    text: 'Por favor selecciona una imagen',
                    icon: 'error'
                });
                return;
            }

            const formData = new FormData(this);
                formData.append('image', selectedFile);
                formData.append('from_patient', 'true');
    
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#addImageModal').modal('hide');
                    Swal.fire({
                        title: '{{ __("global.success") }}',
                        text: '{{ __("global.created_success") }}',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.href = '{{ route('dental_management.patients.show', $patient) }}?tab=images';
                    });
                } else {
                    Swal.fire({
                        title: '{{ __("global.error") }}',
                        text: data.message || 'Error al guardar la imagen',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: '{{ __("global.error") }}',
                    text: 'Error al procesar la solicitud',
                    icon: 'error'
                });
            });
        });
    }

    // Formulario de editar imagen
    if (editImageForm) {
        editImageForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            if (editSelectedFile) {
                formData.append('image', editSelectedFile);
            }
            formData.append('from_patient', 'true');
            formData.append('_method', 'PUT'); // Forzar método PUT

            fetch(this.action, {
                method: 'POST', // Laravel maneja el _method
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#editImageModal').modal('hide');
                    Swal.fire({
                        title: '{{ __("global.success") }}',
                        text: '{{ __("global.updated_success") }}',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.href = '{{ route('dental_management.patients.show', $patient) }}?tab=images';
                    });
                } else {
                    // Mostrar errores de validación
                    if (data.errors) {
                        let errorMessages = [];
                        for (let field in data.errors) {
                            errorMessages.push(data.errors[field].join(', '));
                        }
                        Swal.fire({
                            title: '{{ __("global.error") }}',
                            text: errorMessages.join('\n'),
                            icon: 'error'
                        });
                    } else {
                        Swal.fire({
                            title: '{{ __("global.error") }}',
                            text: data.message || 'Error al actualizar la imagen',
                            icon: 'error'
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: '{{ __("global.error") }}',
                    text: 'Error al procesar la solicitud',
                    icon: 'error'
                });
            });
        });
    }

    function startCamera() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(mediaStream) {
                stream = mediaStream;
                const cameraContainer = document.getElementById('camera-container');
                const video = document.getElementById('camera');
                const captureBtn = document.getElementById('capture-btn');

                cameraContainer.style.display = 'block';
                video.srcObject = mediaStream;
                video.play();
                captureBtn.style.display = 'inline-block';

                captureBtn.addEventListener('click', capturePhoto);
            })
            .catch(function(err) {
                console.error('Error accessing camera:', err);
                Swal.fire({
                    title: '{{ __("global.error") }}',
                    text: 'No se pudo acceder a la cámara.',
                    icon: 'error'
                });
            });
    }

    function capturePhoto() {
        const video = document.getElementById('camera');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function(blob) {
            // Convertir blob a base64 para enviar como campo 'photo'
            const reader = new FileReader();
            reader.onload = function(e) {
                const base64Data = e.target.result;
                // Crear un input hidden para almacenar la imagen base64
                let photoInput = document.getElementById('photo-input');
                if (!photoInput) {
                    photoInput = document.createElement('input');
                    photoInput.type = 'hidden';
                    photoInput.name = 'photo';
                    photoInput.id = 'photo-input';
                    document.getElementById('image-form').appendChild(photoInput);
                }
                photoInput.value = base64Data;

                // También mantener el archivo para preview
                const file = new File([blob], 'photo_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                selectedFile = file;
                showImagePreview(file);
                stopCamera();
            };
            reader.readAsDataURL(blob);
        });
    }

    function showImagePreview(file) {
        const previewContainer = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            const cameraContainer = document.getElementById('camera-container');
            const captureBtn = document.getElementById('capture-btn');

            cameraContainer.style.display = 'none';
            captureBtn.style.display = 'none';
        }
    }

    function startEditCamera() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(mediaStream) {
                editStream = mediaStream;
                const cameraContainer = document.getElementById('edit-camera-container');
                const video = document.getElementById('edit-camera');
                const captureBtn = document.getElementById('edit-capture-btn');

                if (cameraContainer && video && captureBtn) {
                    cameraContainer.style.display = 'block';
                    video.srcObject = mediaStream;
                    video.play();
                    captureBtn.style.display = 'inline-block';

                    captureBtn.addEventListener('click', captureEditPhoto);
                }
            })
            .catch(function(err) {
                console.error('Error accessing camera:', err);
                Swal.fire({
                    title: '{{ __("global.error") }}',
                    text: 'No se pudo acceder a la cámara.',
                    icon: 'error'
                });
            });
    }

    function captureEditPhoto() {
        const video = document.getElementById('edit-camera');
        const canvas = document.getElementById('edit-canvas');
        const context = canvas.getContext('2d');

        if (video && canvas && context) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(function(blob) {
                // Convertir blob a base64 para enviar como campo 'photo'
                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64Data = e.target.result;
                    // Crear un input hidden para almacenar la imagen base64
                    let photoInput = document.getElementById('edit-photo-input');
                    if (!photoInput) {
                        photoInput = document.createElement('input');
                        photoInput.type = 'hidden';
                        photoInput.name = 'photo';
                        photoInput.id = 'edit-photo-input';
                        document.getElementById('edit-image-form').appendChild(photoInput);
                    }
                    photoInput.value = base64Data;

                    // También mantener el archivo para preview
                    const file = new File([blob], 'photo_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                    editSelectedFile = file;
                    showEditImagePreview(file);
                    stopEditCamera();
                };
                reader.readAsDataURL(blob);
            });
        }
    }

    function showEditImagePreview(file) {
        const previewContainer = document.getElementById('edit-image-preview');
        const previewImg = document.getElementById('edit-preview-img');

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    function stopEditCamera() {
        if (editStream) {
            editStream.getTracks().forEach(track => track.stop());
            editStream = null;
        }

        const cameraContainer = document.getElementById('edit-camera-container');
        const captureBtn = document.getElementById('edit-capture-btn');

        if (cameraContainer) cameraContainer.style.display = 'none';
        if (captureBtn) captureBtn.style.display = 'none';
    }

    // Ver imagen en modal con información completa
    function viewImage(imageSrc, title, description, date) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('modalImageTitle').textContent = title || 'Sin título';
        document.getElementById('modalImageDescription').textContent = description || 'Sin descripción';

        // Información adicional
        document.getElementById('modalImageDate').textContent = date || '';

        $('#imageModal').modal('show');
    }

    // Función para manejar eliminación de imagen desde base de datos
    function handleDeleteImage(imageSlug, imageTitle, imageDescription) {
        // Configurar el formulario
        const deleteForm = document.getElementById('deleteImageForm');
        if (deleteForm) {
            deleteForm.action = `{{ url('dental_management/patient_images') }}/${imageSlug}`;
        }

        // Limpiar el campo de razón
        const reasonField = document.getElementById('delete_reason');
        if (reasonField) reasonField.value = '';

        // Mostrar el modal
        $('#deleteImageModal').modal('show');

        // Configurar el envío del formulario
        deleteForm.onsubmit = function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('from_patient', 'true');

            // Validar que se haya ingresado una razón
            const reason = formData.get('reason');
            if (!reason || reason.trim().length < 10) {
                Swal.fire({
                    title: '{{ __("global.error") }}',
                    text: '{{ __("dental_management.patient_images.validation.delete_reason_min") }}',
                    icon: 'error'
                });
                return;
            }

            // Deshabilitar el botón de envío
            const submitBtn = deleteForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("global.processing") }}';

            fetch(deleteForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#deleteImageModal').modal('hide');
                    Swal.fire({
                        title: '{{ __("global.success") }}',
                        text: '{{ __("global.deleted_successfully") }}',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.href = '{{ route('dental_management.patients.show', $patient) }}?tab=images';
                    });
                } else {
                    // Mostrar errores de validación
                    if (data.errors && data.errors.reason) {
                        Swal.fire({
                            title: '{{ __("global.error") }}',
                            text: data.errors.reason[0],
                            icon: 'error'
                        });
                    } else {
                        Swal.fire({
                            title: '{{ __("global.error") }}',
                            text: data.message || '{{ __("global.error_occurred") }}',
                            icon: 'error'
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: '{{ __("global.error") }}',
                    text: '{{ __("global.error_occurred") }}',
                    icon: 'error'
                });
            })
            .finally(() => {
                // Rehabilitar el botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-trash"></i> {{ __("global.yes_delete") }}';
            });
        };
    }

    // Función para manejar edición de imagen
    function handleEditImage(imageId, imageTitle, imageDescription, imageSrc) {
        // Llenar el modal con información actual
        const titleField = document.getElementById('edit_title');
        const descriptionField = document.getElementById('edit_description');

        if (titleField) titleField.value = imageTitle || '';
        if (descriptionField) descriptionField.value = imageDescription || '';

        // Mostrar imagen actual
        const currentPreview = document.getElementById('current-image-preview');
        const currentImg = document.getElementById('current-preview-img');

        if (currentImg && currentPreview) {
            currentImg.src = imageSrc;
            currentPreview.style.display = 'block';
        }

        // Configurar formulario
        const editForm = document.getElementById('edit-image-form');
        if (editForm) {
            editForm.action = `{{ url('dental_management/patient_images') }}/${imageId}`;
        }

        // Limpiar campos de nueva imagen
        editSelectedFile = null;
        const editPreview = document.getElementById('edit-image-preview');
        if (editPreview) editPreview.style.display = 'none';
        stopEditCamera();

        // Mostrar modal
        $('#editImageModal').modal('show');
    }

    // Event delegation para botones dinámicos
    document.addEventListener('click', function(e) {
        // Prevenir bubbling si viene de SweetAlert2
        if (e.target.closest('.swal2-container')) {
            return;
        }

        // Ver imagen
         if (e.target.classList.contains('view-image') || e.target.closest('.view-image')) {
             e.preventDefault();
             const button = e.target.classList.contains('view-image') ? e.target : e.target.closest('.view-image');
             const imageSrc = button.getAttribute('data-image');
             const title = button.getAttribute('data-title');
             const description = button.getAttribute('data-description');
             const date = button.getAttribute('data-date');
             viewImage(imageSrc, title, description, date);
         }

        // Editar imagen
        if (e.target.classList.contains('edit-image') || e.target.closest('.edit-image')) {
            e.preventDefault();
            e.stopPropagation();

            const button = e.target.classList.contains('edit-image') ? e.target : e.target.closest('.edit-image');
            const imageId = button.getAttribute('data-id');
            const imageSlug = button.getAttribute('data-slug');
            const imageTitle = button.getAttribute('data-title');
            const imageDescription = button.getAttribute('data-description') || '';
            const imageSrc = button.getAttribute('data-image');

            if (imageSlug) {
                handleEditImage(imageSlug, imageTitle, imageDescription, imageSrc);
            }
        }

        // Eliminar imagen
        if (e.target.classList.contains('delete-image') || e.target.closest('.delete-image')) {
            e.preventDefault();
            e.stopPropagation();

            const button = e.target.classList.contains('delete-image') ? e.target : e.target.closest('.delete-image');
            const imageId = button.getAttribute('data-id');
            const imageSlug = button.getAttribute('data-slug');
            const imageTitle = button.getAttribute('data-title');

            if (imageSlug) {
                const imageDescription = button.getAttribute('data-description') || '';
                handleDeleteImage(imageSlug, imageTitle, imageDescription);
            }
        }
    });

    // Limpiar modal al cerrarse
    $('#addImageModal').on('hidden.bs.modal', function() {
        const form = document.getElementById('image-form');
        if (form) form.reset();

        const preview = document.getElementById('image-preview');
        if (preview) preview.style.display = 'none';

        // Eliminar campo photo oculto si existe
        const photoInput = document.getElementById('photo-input');
        if (photoInput) photoInput.remove();

        selectedFile = null;
        stopCamera();
    });

    $('#editImageModal').on('hidden.bs.modal', function() {
        const form = document.getElementById('edit-image-form');
        if (form) form.reset();

        const currentPreview = document.getElementById('current-image-preview');
        if (currentPreview) currentPreview.style.display = 'none';

        const editPreview = document.getElementById('edit-image-preview');
        if (editPreview) editPreview.style.display = 'none';

        // Eliminar campo photo oculto si existe
        const photoInput = document.getElementById('edit-photo-input');
        if (photoInput) photoInput.remove();

        editSelectedFile = null;
        stopEditCamera();
    });
});
</script>
