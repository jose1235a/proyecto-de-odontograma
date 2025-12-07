# 📸 Sistema de Imágenes de Pacientes - Gestión Dental

## 📋 Descripción General

Este módulo implementa un **sistema completo de gestión de imágenes** para pacientes en la aplicación de gestión dental. Permite subir imágenes desde archivos locales, capturar fotos con la webcam, visualizarlas en una galería organizada y eliminarlas con control de auditoría.

## 🏗️ Arquitectura del Sistema

### Componentes Principales
1. **Backend**: Controlador `PatientImageController` con métodos RESTful
2. **Base de Datos**: Tabla `patient_images` con soft deletes y auditoría
3. **Almacenamiento**: Sistema de archivos con enlace simbólico
4. **Frontend**: Modal interactivo con webcam integrada
5. **Validación**: Form requests con reglas específicas

---

## ⚙️ Configuración e Instalación

### 1. Migración de Base de Datos
```bash
php artisan migrate
```

### 2. Enlace Simbólico de Almacenamiento
```bash
php artisan storage:link
```

### 3. Permisos de Directorio
```bash
chmod -R 755 storage/app/public/patient_images
```

---

## 📁 Estructura de Archivos

### Backend
```
app/
├── Http/Controllers/DentalManagement/PatientImageController.php
├── Http/Requests/DentalManagement/PatientImage/
│   ├── StoreRequest.php
│   ├── UpdateRequest.php
│   └── DeleteRequest.php
├── Models/PatientImage.php
└── Services/DentalManagement/PatientImageService.php

database/migrations/
└── 2025_11_19_064344_create_patient_images_table.php

resources/
├── lang/es/dental_management.php
└── views/dental_management/patients/partials/form_show_images.blade.php
```

### Almacenamiento
```
storage/app/public/patient_images/
├── patient_1_img_1732012345_abc123.jpg
├── patient_1_photo_1732012346_def456.jpg
├── patient_2_img_1732012347_ghi789.png
└── ...
```

---

## 🔧 Funcionalidades Implementadas

### ✅ Subida de Imágenes
- **Selector de archivos**: Interfaz nativa del navegador
- **Validación de tipos**: JPG, PNG, GIF hasta 5MB
- **Nombres únicos**: Prefijos por paciente + timestamp + uniqid
- **Preview en tiempo real**: Antes de guardar

### ✅ Captura con Webcam
- **Acceso a cámara**: API getUserMedia
- **Canvas para captura**: Procesamiento en tiempo real
- **Formato automático**: Conversión a JPG
- **Fallback**: Funciona sin cámara disponible

### ✅ Galería de Visualización
- **Grid responsive**: 4 columnas en desktop, adaptable
- **Modal expandido**: Vista completa con información
- **Metadatos**: Título, descripción, fecha, usuario
- **Navegación intuitiva**: Click para expandir

### ✅ Eliminación con Auditoría
- **Modal de confirmación**: Motivo obligatorio (10-500 caracteres)
- **Soft delete**: Registros preservados para auditoría
- **Eliminación física**: Archivos removidos del servidor
- **Auditoría completa**: `deleted_by`, `deleted_description`, `deleted_at`

---

## 🎨 Interfaz de Usuario

### Modal de Agregar Imagen
```html
<!-- Botón principal -->
<button class="btn btn-primary" data-toggle="modal" data-target="#addImageModal">
  <i class="fas fa-plus"></i> Agregar Imagen
</button>

<!-- Opciones de subida -->
<div class="mb-2">
  <button class="btn btn-outline-primary" id="upload-image-btn">
    <i class="fas fa-upload"></i> Subir Archivo
  </button>
  <button class="btn btn-outline-success" id="take-photo-btn">
    <i class="fas fa-camera"></i> Tomar Foto
  </button>
</div>
```

### Galería de Imágenes
```html
<div class="row" id="images-container">
  @foreach($patient->patientImages->where('is_active', true) as $image)
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <img src="{{ $image->image_url }}" class="card-img-top" style="height: 200px;">
        <div class="card-body">
          <h6>{{ $image->title }}</h6>
          <p>{{ Str::limit($image->description, 100) }}</p>
        </div>
        <div class="card-footer">
          <button class="btn btn-info">Ver</button>
          <button class="btn btn-danger">Eliminar</button>
        </div>
      </div>
    </div>
  @endforeach
</div>
```

---

## 🔐 Validación y Seguridad

### StoreRequest - Creación
```php
public function rules(): array
{
    return [
        'patient_id' => 'required|exists:patients,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
    ];
}
```

### DeleteRequest - Eliminación
```php
public function rules(): array
{
    return [
        'reason' => 'required|string|min:10|max:500',
    ];
}
```

### Seguridad de Archivos
- **Nombres únicos**: Evita colisiones y accesos no autorizados
- **Prefijos por paciente**: `patient_{id}_`
- **Validación de tipos**: Solo imágenes permitidas
- **Límite de tamaño**: Máximo 5MB por archivo

---

## 📊 Base de Datos

### Tabla `patient_images`
```sql
CREATE TABLE patient_images (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    title VARCHAR(255) NOT NULL,
    filename VARCHAR(255) NOT NULL,
    description TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT NULL,
    deleted_by BIGINT NULL,
    deleted_description TEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (deleted_by) REFERENCES users(id)
);
```

### Relaciones
```php
// En modelo Patient
public function patientImages()
{
    return $this->hasMany(PatientImage::class);
}

// En modelo PatientImage
public function patient()
{
    return $this->belongsTo(Patient::class);
}
```

---

## 🚀 API Endpoints

### Crear Imagen
```http
POST /dental_management/patient_images
Content-Type: multipart/form-data

{
  "patient_id": 1,
  "title": "Radiografía panorámica",
  "description": "Radiografía completa de arcada superior",
  "image": [archivo]
}
```

### Eliminar Imagen
```http
DELETE /dental_management/patient_images/{id}
Content-Type: application/x-www-form-urlencoded

{
  "reason": "Imagen duplicada, se reemplaza por versión actualizada",
  "_token": "csrf_token"
}
```

---

## 🎯 Casos de Uso

### 1. Subida de Radiografías
- **Odontólogo** toma radiografía con equipo digital
- **Asistente** sube archivo desde el formulario del paciente
- **Sistema** valida formato y tamaño
- **Paciente** puede ver su historial radiográfico

### 2. Fotos de Procedimientos
- **Antes del tratamiento**: Foto del estado inicial
- **Durante el tratamiento**: Documentación del progreso
- **Después del tratamiento**: Resultado final
- **Auditoría**: Todas las fotos con fecha y usuario

### 3. Captura con Webcam
- **Consultas remotas**: Fotos en tiempo real
- **Documentación**: Estados de tejidos blandos
- **Sin equipo adicional**: Usa webcam del computador

---

## 🔧 Configuración Avanzada

### Variables de Entorno
```env
# Tamaño máximo de archivos (KB)
PATIENT_IMAGE_MAX_SIZE=5120

# Tipos MIME permitidos
PATIENT_IMAGE_MIME_TYPES=jpeg,png,jpg,gif

# Directorio de almacenamiento
PATIENT_IMAGES_PATH=patient_images
```

### Personalización de Nombres
```php
// En PatientImageService
private function generateFilename($patientId, $type = 'img')
{
    $prefix = "patient_{$patientId}_{$type}";
    $timestamp = time();
    $unique = uniqid();
    $extension = $this->getValidExtension($request->file('image'));

    return "{$prefix}_{$timestamp}_{$unique}.{$extension}";
}
```

---

## 📈 Estadísticas y Métricas

### KPIs del Sistema
- **Total de imágenes**: Número total almacenadas
- **Imágenes por paciente**: Promedio de imágenes por paciente
- **Uso de almacenamiento**: Espacio ocupado por imágenes
- **Tipos de archivo**: Distribución JPG/PNG/GIF

### Monitoreo
```php
// Número de imágenes por paciente
$imagesCount = PatientImage::where('patient_id', $patientId)
    ->where('is_active', true)
    ->count();

// Espacio usado
$imagesSize = PatientImage::where('patient_id', $patientId)
    ->join('files', 'patient_images.filename', '=', 'files.name')
    ->sum('files.size');
```

---

## 🐛 Solución de Problemas

### Error: "No query results for model"
**Solución**: Verificar que el ID de la imagen existe en la base de datos antes de eliminar.

### Error: "File not found"
**Solución**: Asegurar que el enlace simbólico `storage:link` esté creado.

### Error: "Permission denied"
**Solución**: Verificar permisos 755 en `storage/app/public/patient_images`.

### Webcam no funciona
**Solución**: Verificar HTTPS en producción o configuración de permisos del navegador.

---

## 🎉 Conclusión

El **Sistema de Imágenes de Pacientes** proporciona una solución completa para la gestión documental en clínicas dentales, con:

- ✅ **Interfaz intuitiva**: Fácil de usar para todo el personal
- ✅ **Seguridad robusta**: Validación y auditoría completas
- ✅ **Flexibilidad**: Múltiples formas de captura
- ✅ **Escalabilidad**: Arquitectura preparada para crecimiento
- ✅ **Integración**: Perfectamente integrado con el sistema de pacientes

**Estado**: ✅ **100% Funcional y Documentado**