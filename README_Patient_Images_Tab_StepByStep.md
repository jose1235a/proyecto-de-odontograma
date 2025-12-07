# 📸 Análisis Paso a Paso: Tab de Imágenes del Paciente

## 📋 Introducción

El tab de imágenes del paciente es un módulo completo de gestión de imágenes médicas que permite subir, visualizar, editar y eliminar imágenes asociadas a un paciente. Incluye funcionalidades avanzadas como captura con webcam, galerías responsive y gestión completa de archivos.

## 🗂️ PASO 1: Integración en la Vista de Detalles

### 1.1 Ubicación en el Sistema de Tabs

**Archivo**: `resources/views/dental_management/patients/show.blade.php`

```php
<!-- Tab de Imágenes en la navegación -->
<li class="nav-item">
  <a class="nav-link" id="images-tab" data-toggle="pill" href="#images" role="tab" aria-selected="false">
    <i class="fas fa-images"></i> {{ __('dental_management.patients.images') }}
  </a>
</li>
```

**Contenido del tab:**
```php
<!-- Images Tab -->
<div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
  @include('dental_management.patients.partials.form_show_images')
</div>
```

### 1.2 Relación en el Modelo Patient

**Archivo**: `app/Models/Patient.php`

```php
// Relación con imágenes del paciente
public function patientImages()
{
    return $this->hasMany(PatientImage::class)->notDeleted();
}
```

**Carga en el controlador:**
```php
public function show(Patient $patient): View
{
    // Las imágenes se cargan automáticamente a través de la relación
    // No es necesario cargarlas explícitamente ya que se accede vía $patient->patientImages
}
```

## 🎨 PASO 2: Estructura del Partial de Imágenes

### 2.1 Layout Principal

**Archivo**: `resources/views/dental_management/patients/partials/form_show_images.blade.php`

```php
<!-- PASO 1: Botón para agregar imagen -->
<div class="mb-3">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addImageModal">
    <i class="fas fa-plus"></i> {{ __('dental_management.patients.upload_image') }}
  </button>
</div>

<!-- PASO 2: Galería de imágenes existentes -->
@if($patient->patientImages && $patient->patientImages->count() > 0)
  <div class="row" id="images-container">
    @foreach($patient->patientImages->where('is_active', true) as $patientImage)
      <!-- Cards de imágenes -->
    @endforeach
  </div>
@else
  <!-- Mensaje cuando no hay imágenes -->
  <div class="alert alert-info">
    <i class="fas fa-info-circle"></i> {{ __('dental_management.patient_images.no_images') }}
  </div>
@endif
```

### 2.2 Cards de Imágenes

```php
<div class="col-md-3 mb-4">
  <div class="card h-100">
    <!-- PASO 1: Imagen con click para ver -->
    <img src="{{ $patientImage->image_url }}" class="card-img-top"
         alt="{{ $patientImage->title }}" style="height: 200px; object-fit: cover; cursor: pointer;"
         onclick="viewImage('{{ $patientImage->image_url }}', '{{ $patientImage->title }}', '{{ $patientImage->description }}', '{{ $patientImage->created_at->format('d/m/Y H:i') }}')">

    <!-- PASO 2: Información de la imagen -->
    <div class="card-body d-flex flex-column">
      <div class="mb-2">
        <small class="font-weight-bold">
          <i class="fas fa-calendar"></i> {{ $patientImage->created_at->format('d/m/Y H:i') }}
        </small>
      </div>
      @if($patientImage->description)
        <p class="card-text text-muted flex-grow-1">
          {{ Str::limit($patientImage->description, 100) }}
        </p>
      @endif
    </div>

    <!-- PASO 3: Botones de acción -->
    <div class="card-footer p-2">
      <div class="btn-group btn-group-sm w-100" role="group">
        <button type="button" class="btn btn-outline-info view-image" ...>
          <i class="fas fa-eye"></i> Ver
        </button>
        <button type="button" class="btn btn-outline-warning edit-image" ...>
          <i class="fas fa-edit"></i> Editar
        </button>
        <button type="button" class="btn btn-outline-danger delete-image" ...>
          <i class="fas fa-trash"></i> Eliminar
        </button>
      </div>
    </div>
  </div>
</div>
```

## 📝 PASO 3: Modal de Agregar Imagen

### 3.1 Estructura HTML del Modal

```php
<!-- Modal para agregar imagen -->
<div class="modal fade" id="addImageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-image"></i> {{ __('dental_management.patient_images.create') }}
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- PASO 1: Formulario -->
      <form id="image-form" action="{{ route('dental_management.patient_images.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
        <div class="modal-body">
          <!-- Campos del formulario -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
```

### 3.2 Campos del Formulario

#### Información del Paciente (solo lectura)
```php
<div class="row mb-3">
  <div class="col-md-3">
    <label class="font-weight-bold">{{ __('dental_management.patient_images.patient_id') }}</label>
  </div>
  <div class="col-md-9">
    <input type="text" class="form-control" value="{{ $patient->name }} {{ $patient->last_name }}" readonly>
  </div>
</div>
```

#### Título (requerido)
```php
<div class="row mb-3">
  <div class="col-md-3">
    <label for="title" class="font-weight-bold">{{ __('dental_management.patient_images.title') }} <span class="text-danger">(*)</span></label>
  </div>
  <div class="col-md-9">
    <input type="text" name="title" id="title" class="form-control" required
           placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patient_images.title')]) }}">
  </div>
</div>
```

#### Opciones de Imagen
```php
<div class="row mb-3">
  <div class="col-md-3">
    <label class="font-weight-bold">{{ __('dental_management.patient_images.image') }} <span class="text-danger">(*)</span></label>
  </div>
  <div class="col-md-9">
    <!-- PASO 1: Botones de selección -->
    <div class="mb-2">
      <button type="button" class="btn btn-outline-primary btn-sm" id="upload-image-btn">
        <i class="fas fa-upload"></i> {{ __('dental_management.patients.upload_image') }}
      </button>
      <button type="button" class="btn btn-outline-success btn-sm" id="take-photo-btn">
        <i class="fas fa-camera"></i> {{ __('dental_management.patients.take_photo') }}
      </button>
    </div>

    <!-- PASO 2: Input file oculto -->
    <input type="file" name="image" id="image-input" accept="image/*" style="display: none;">

    <!-- PASO 3: Contenedor de cámara -->
    <div id="camera-container" style="display: none;">
      <video id="camera" style="width: 100%; max-width: 400px; border: 1px solid #ddd;"></video>
      <button type="button" class="btn btn-warning btn-sm mt-2" id="capture-btn" style="display: none;">
        <i class="fas fa-camera"></i> Capturar Foto
      </button>
    </div>
    <canvas id="canvas" style="display: none;"></canvas>

    <!-- PASO 4: Preview de imagen -->
    <div id="image-preview" class="mt-2" style="display: none;">
      <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
    </div>
  </div>
</div>
```

#### Descripción (opcional)
```php
<div class="row mb-3">
  <div class="col-md-3">
    <label for="description" class="font-weight-bold">{{ __('dental_management.patient_images.description') }}</label>
  </div>
  <div class="col-md-9">
    <textarea name="description" id="description" class="form-control" rows="3"
              placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patient_images.description')]) }}"></textarea>
  </div>
</div>
```

## 📸 PASO 4: Funcionalidad de Cámara Web

### 4.1 JavaScript para Cámara

```javascript
// PASO 1: Solicitar permisos y mostrar video
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
            // Mostrar error al usuario
        });
}

// PASO 2: Capturar foto del video
function capturePhoto() {
    const video = document.getElementById('camera');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // PASO 3: Convertir a blob y crear preview
    canvas.toBlob(function(blob) {
        const file = new File([blob], 'photo_' + Date.now() + '.jpg', { type: 'image/jpeg' });
        selectedFile = file;
        showImagePreview(file);
        stopCamera();
    });
}
```

### 4.2 Preview de Imagen

```javascript
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
```

## 🔧 PASO 5: Procesamiento en el Backend

### 5.1 Método Store del Controlador

**Archivo**: `app/Http/Controllers/DentalManagement/PatientImageController.php`

```php
public function store(StoreRequest $request)
{
    try {
        $data = $request->validated();

        // PASO 1: Procesar archivo subido
        if ($request->hasFile('image')) {
            $patientImagesPath = storage_path('app/public/patient_images');

            // Crear directorio si no existe
            if (!file_exists($patientImagesPath)) {
                mkdir($patientImagesPath, 0755, true);
            }

            // Generar nombre único
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = 'patient_' . $data['patient_id'] . '_img_' . time() . '_' . uniqid() . '.' . $extension;

            // Mover archivo
            $request->file('image')->move($patientImagesPath, $filename);

            // Crear registro en BD
            $patientImageData = [
                'patient_id' => $data['patient_id'],
                'title' => $data['title'],
                'filename' => $filename,
                'description' => $data['description'] ?? null,
                'created_by' => auth()->id(),
            ];

            $patientImage = PatientImage::create($patientImageData);

        // PASO 2: Procesar foto de webcam
        } elseif ($request->filled('photo')) {
            // Procesar imagen base64
            $imageData = $request->input('photo');
            $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $imageBinary = base64_decode($imageData);

            // Generar nombre único
            $filename = 'patient_' . $data['patient_id'] . '_photo_' . time() . '_' . uniqid() . '.jpg';

            // Guardar archivo
            file_put_contents($patientImagesPath . '/' . $filename, $imageBinary);

            // Crear registro en BD (igual que arriba)
            $patientImage = PatientImage::create($patientImageData);
        }

        // PASO 3: Respuesta
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('dental_management.patient_images.create'),
                'data' => $patientImage
            ]);
        }

        // Redirect con tab activo
        $patient = Patient::find($data['patient_id']);
        return redirect()->route('dental_management.patients.show', [
            $patient ? $patient->slug : $data['patient_id'],
            'tab' => 'images'
        ])->with('success', __('dental_management.patient_images.create'));

    } catch (\Exception $e) {
        // Manejo de errores
    }
}
```

### 5.2 Modelo PatientImage

**Archivo**: `app/Models/PatientImage.php`

```php
class PatientImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'title',
        'filename',
        'description',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    // PASO 1: Generar slug único
    protected static function booted()
    {
        static::creating(function ($patientImage) {
            do {
                $slug = Str::random(22);
            } while (PatientImage::where('slug', $slug)->exists());

            $patientImage->slug = $slug;
        });
    }

    // PASO 2: Usar slug como route key
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // PASO 3: Relación con paciente
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // PASO 4: Accessor para URL de imagen
    public function getImageUrlAttribute()
    {
        return asset('storage/patient_images/' . $this->filename);
    }

    // PASO 5: Scopes para filtrado
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeFilter(Builder $query, Request|array $filters): Builder
    {
        // Filtros aplicables
    }
}
```

## 🗑️ PASO 6: Funcionalidad de Edición y Eliminación

### 6.1 Modal de Edición

```php
<!-- Modal para editar imagen -->
<div class="modal fade" id="editImageModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-edit"></i> {{ __('dental_management.patient_images.edit') }}
        </h5>
      </div>
      <form id="editImageForm" action="" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Campos similares al modal de agregar -->
      </form>
    </div>
  </div>
</div>
```

### 6.2 Modal de Eliminación

```php
<!-- Modal para eliminar imagen -->
<div class="modal fade" id="deleteImageModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-trash text-danger"></i> {{ __('global.confirm_delete') }}
        </h5>
      </div>
      <form id="deleteImageForm">
        @csrf
        @method('DELETE')
        <div class="modal-body">
          <div class="alert alert-warning">
            <strong>{{ __('global.attention') }}:</strong> {{ __('global.confirm_delete_text') }}
          </div>
          <div class="form-group">
            <label for="delete_reason" class="font-weight-bold">
              {{ __('dental_management.patient_images.fields.delete_reason') }} <span class="text-danger">(*)</span>
            </label>
            <textarea name="reason" id="delete_reason" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>
```

### 6.3 JavaScript para Operaciones

```javascript
// PASO 1: Manejar edición
function handleEditImage(imageId, imageTitle, imageDescription, imageSrc) {
    // Llenar modal con datos actuales
    document.getElementById('edit_title').value = imageTitle || '';
    document.getElementById('edit_description').value = imageDescription || '';
    document.getElementById('editImagePreview').src = imageSrc;

    // Configurar formulario
    const editForm = document.getElementById('editImageForm');
    editForm.action = `{{ url('dental_management/patient_images') }}/${imageId}`;

    // Enviar formulario
    editForm.onsubmit = function(e) {
        e.preventDefault();
        // Lógica AJAX para actualizar
    };
}

// PASO 2: Manejar eliminación
function handleDeleteImage(imageId, imageTitle, imageDescription) {
    // Configurar formulario
    const deleteForm = document.getElementById('deleteImageForm');
    deleteForm.action = `{{ url('dental_management/patient_images') }}/${imageId}`;

    // Enviar formulario
    deleteForm.onsubmit = function(e) {
        e.preventDefault();
        // Lógica AJAX para eliminar
    };
}
```

## 👁️ PASO 7: Modal de Visualización

### 7.1 Modal de Imagen Completa

```php
<!-- Modal para ver imagen -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Imagen del paciente</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8 text-center">
            <img id="modalImage" src="" alt="Imagen del paciente" class="img-fluid" style="max-height: 70vh;">
          </div>
          <div class="col-md-4">
            <h3 id="modalImageDate" class="font-weight-bold text-dark mb-3">
              <i class="fas fa-calendar"></i>
            </h3>
            <div class="row mb-2">
              <div class="col-4"><strong>Título:</strong></div>
              <div class="col-8"><span id="modalImageTitle"></span></div>
            </div>
            <div class="row">
              <div class="col-4"><strong>Descripción:</strong></div>
              <div class="col-8"><span id="modalImageDescription"></span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
```

### 7.2 Función JavaScript para Visualización

```javascript
function viewImage(imageSrc, title, description, date) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalImageTitle').textContent = title || 'Sin título';
    document.getElementById('modalImageDescription').textContent = description || 'Sin descripción';
    document.getElementById('modalImageDate').textContent = date || '';

    $('#imageModal').modal('show');
}
```

## 🛣️ PASO 8: Sistema de Rutas

### 8.1 Rutas Definidas

**Archivo**: `routes/dental_management.php`

```php
// Rutas de imágenes de pacientes
Route::get('patient_images/export_excel', [PatientImageController::class, 'exportExcel'])->name('patient_images.export_excel');
Route::get('patient_images/export_pdf',   [PatientImageController::class, 'exportPdf'])->name('patient_images.export_pdf');
Route::get('patient_images/export_word',  [PatientImageController::class, 'exportWord'])->name('patient_images.export_word');
Route::get('patient_images/edit_all',     [PatientImageController::class, 'editAll'])->name('patient_images.edit_all');

// Resource route para CRUD completo
Route::resource('patient_images', PatientImageController::class)->names('patient_images');

// Rutas adicionales
Route::get('patient_images/{patient_image}/delete', [PatientImageController::class, 'delete'])->name('patient_images.delete');
Route::delete('patient_images/{patient_image}/deleteSave', [PatientImageController::class, 'deleteSave'])->name('patient_images.deleteSave');
```

### 8.2 Control de Acceso Condicional

```php
public function __construct(
    private PatientImageService $patientImageService
) {
    // Solo aplicar middleware cuando NO se accede desde el paciente
    if (!request()->has('from_patient') || request()->get('from_patient') !== 'true') {
        $this->middleware('permission:patient_images.view')->only(['index', 'show']);
        $this->middleware('permission:patient_images.create')->only(['create', 'store']);
        $this->middleware('permission:patient_images.edit')->only(['edit', 'update', 'editAll']);
        $this->middleware('permission:patient_images.delete')->only(['delete', 'deleteSave']);
        $this->middleware('permission:patient_images.export')->only(['exportExcel', 'exportPdf', 'exportWord']);
    }
}
```

## 📊 PASO 9: Gestión de Archivos

### 9.1 Estructura de Almacenamiento

```
storage/
├── app/
│   └── public/
│       └── patient_images/
│           ├── patient_123_img_1642598400_abc123.jpg
│           ├── patient_123_photo_1642598500_def456.jpg
│           └── ...
```

### 9.2 Nombres de Archivos

**Formato para imágenes subidas:**
```
patient_{patient_id}_img_{timestamp}_{uniqid}.{extension}
```

**Formato para fotos tomadas:**
```
patient_{patient_id}_photo_{timestamp}_{uniqid}.jpg
```

### 9.3 Limpieza de Archivos

```php
// Al actualizar imagen
if ($request->hasFile('image')) {
    // Eliminar imagen anterior
    $oldImagePath = storage_path('app/public/patient_images/' . $patientImage->filename);
    if (file_exists($oldImagePath)) {
        unlink($oldImagePath);
    }
    // Procesar nueva imagen...
}
```

## 🔄 PASO 10: Integración Completa

### 10.1 Flujo de Trabajo

1. **Usuario abre tab de imágenes** → Se cargan imágenes del paciente
2. **Click "Agregar imagen"** → Se abre modal con opciones
3. **Usuario selecciona método** → Subida de archivo o captura con cámara
4. **Preview y confirmación** → Se muestra preview antes de guardar
5. **Envío del formulario** → Procesamiento AJAX o tradicional
6. **Actualización de galería** → Se recarga la vista con nueva imagen
7. **Operaciones CRUD** → Editar, ver, eliminar con modales

### 10.2 Estados y Validaciones

#### Estados de Imágenes
- **Activa**: Visible en galería (`is_active = true`)
- **Eliminada**: Soft delete (`deleted_at` no null)

#### Validaciones
- **Título**: Requerido, máximo 255 caracteres
- **Descripción**: Opcional, máximo 1000 caracteres
- **Imagen**: Requerida, tipos: jpeg, png, jpg, gif
- **Tamaño**: Máximo configurable (actualmente sin límite específico)

### 10.3 Manejo de Errores

```javascript
// Errores en AJAX
if (data.errors) {
    let errorMessages = [];
    for (let field in data.errors) {
        errorMessages.push(data.errors[field][0]);
    }
    Swal.fire({
        title: 'Error',
        html: errorMessages.join('<br>'),
        icon: 'error'
    });
}
```

## 🎯 PASO 11: Optimizaciones y Mejores Prácticas

### 11.1 Performance

#### Lazy Loading de Imágenes
```html
<img loading="lazy" src="..." alt="..." style="height: 200px; object-fit: cover;">
```

#### Paginación en Listados Grandes
```php
// Si hay muchas imágenes, implementar paginación
$patientImages = $patient->patientImages()->paginate(12);
```

### 11.2 Seguridad

#### Validación de Propiedad
```javascript
// Verificar que la imagen pertenece al paciente
if (strpos($imageName, 'patient_' . $patient->id . '_') !== 0) {
    return response()->json(['success' => false, 'message' => 'La imagen no pertenece a este paciente'], 403);
}
```

#### Sanitización de Nombres de Archivo
```php
// Generar nombres seguros
$filename = 'patient_' . $data['patient_id'] . '_img_' . time() . '_' . uniqid() . '.' . $extension;
```

### 11.3 UX/UI

#### Feedback Visual
- **Loading states** en botones durante operaciones
- **Toast notifications** para confirmaciones
- **Progress indicators** para uploads grandes

#### Responsive Design
- **Grid adaptable**: 1-4 columnas según pantalla
- **Modal sizing**: `modal-lg` para desktop, `modal-xl` para imágenes
- **Touch friendly**: Botones de tamaño adecuado

## ✅ Conclusión

El tab de imágenes del paciente es un módulo completo que incluye:

1. **Galería responsive** con cards de imágenes
2. **Múltiples métodos de input** (subida + webcam)
3. **CRUD completo** con modales y AJAX
4. **Gestión de archivos** segura y organizada
5. **Integración perfecta** con el perfil del paciente
6. **UI/UX optimizada** para diferentes dispositivos

**Características destacadas:**
- ✅ Captura con webcam integrada
- ✅ Preview en tiempo real
- ✅ Gestión completa de archivos
- ✅ Soft deletes con auditoría
- ✅ AJAX para mejor UX
- ✅ Responsive y accesible
- ✅ Control de permisos granular

**Arquitectura**: Componentes modulares con separación clara de responsabilidades

**Tecnologías**: HTML5 Canvas, WebRTC, AJAX, Bootstrap Modals

**Estado**: ✅ **100% Funcional y Optimizado**