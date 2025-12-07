# Módulo de Imágenes del Paciente

## ⚠️ IMPORTANTE: Carpeta de Imágenes en ZIP

**La carpeta `storage/app/public/patient_images/` NO desaparece al comprimir el proyecto, pero estará VACÍA.**

### Por qué está vacía:
- La carpeta `storage/` está excluida del control de versiones (.gitignore)
- Las imágenes subidas por usuarios no se incluyen en el repositorio
- Solo se mantiene la estructura de carpetas

### Después de descomprimir el ZIP:
```bash
# Crear directorio de imágenes
mkdir -p storage/app/public/patient_images
chmod 755 storage/app/public/patient_images

# Crear enlace simbólico
php artisan storage:link
```

---

## ⚠️ IMPORTANTE: Almacenamiento de Imágenes

### Ubicación Física en el Servidor

**Directorio local del proyecto:**
```
c:/laragon/www/blog_main_base/storage/app/public/patient_images/
```

**En el servidor de producción:**
```
/var/www/html/storage/app/public/patient_images/
```

### Proceso de Almacenamiento
1. **Recepción del archivo**: El usuario sube una imagen vía formulario
2. **Procesamiento**: El controlador `PatientImageController` recibe el archivo
3. **Generación de nombre**: Se crea un nombre único:
   ```php
   $filename = 'patient_' . $patientId . '_img_' . time() . '_' . uniqid() . '.' . $extension;
   ```
4. **Almacenamiento**: El archivo se mueve al directorio
5. **Registro en BD**: Se guarda el nombre del archivo en la tabla `patient_images`

### Acceso a las Imágenes
**URL pública:**
```
https://tudominio.com/storage/patient_images/patient_1_img_1640995200_abc123.jpg
```

**Enlace simbólico requerido:**
```bash
php artisan storage:link
```

### Consideraciones Críticas
- **Permisos**: El directorio debe tener permisos de escritura (755)
- **Espacio**: Monitorear el uso de disco
- **Backup**: Incluir en backups del sistema
- **CDN**: Para producción, considerar usar CDN para mejor performance

---

## Descripción General

El módulo de imágenes permite gestionar las imágenes asociadas a los pacientes en el sistema de gestión dental. Incluye funcionalidades para subir, ver, editar y eliminar imágenes, tanto desde la vista del paciente como desde modales interactivos.

## Almacenamiento de Imágenes

### Ubicación Física
Las imágenes se almacenan en el directorio del servidor:
```
storage/app/public/patient_images/
```

### Nomenclatura de Archivos
Los archivos siguen el patrón:
```
patient_{patient_id}_img_{timestamp}_{uniqid}.{extension}
```
- `patient_id`: ID del paciente
- `timestamp`: Marca de tiempo Unix
- `uniqid`: ID único generado
- `extension`: Extensión del archivo (jpg, png, gif)

### Acceso Público
Las imágenes son accesibles vía URL pública:
```
http://dominio.com/storage/patient_images/filename.jpg
```

## Estructura de Archivos

### Modelos
- `app/Models/PatientImage.php`: Modelo principal
- `app/Models/Patient.php`: Relación con pacientes

### Controladores
- `app/Http/Controllers/DentalManagement/PatientImageController.php`: Controlador principal
- `app/Http/Controllers/DentalManagement/PatientController.php`: Métodos auxiliares

### Servicios
- `app/Services/DentalManagement/PatientImageService.php`: Lógica de negocio

### Vistas
- `resources/views/dental_management/patients/partials/form_show_images.blade.php`: Vista principal del tab
- `resources/views/dental_management/patient_images/`: Vistas independientes (no utilizadas en el tab)

## Rutas

### Rutas del Tab de Imágenes
```php
// Mostrar imágenes del paciente (tab)
GET /dental_management/patients/{patient}/show?tab=images

// Crear imagen
POST /dental_management/patient_images

// Actualizar imagen
PUT /dental_management/patient_images/{patientImage}

// Eliminar imagen
DELETE /dental_management/patient_images/{patientImage}
```

### Rutas Auxiliares
```php
// Subir imagen al paciente
POST /dental_management/patients/{patient}/upload-image

// Eliminar imagen del paciente
DELETE /dental_management/patients/{patient}/delete-image
```

## Funcionalidades del Tab

### 1. Visualización de Imágenes

**Ubicación**: Tab "Imágenes" en la vista del paciente (`show.blade.php`)

**Código relevante**:
```php
@include('dental_management.patients.partials.form_show_images')
```

**Características**:
- Muestra imágenes en tarjetas de 3 columnas
- Solo imágenes activas (`is_active = true`)
- Información: fecha/hora, descripción
- Botones: Ver, Editar, Eliminar

### 2. Agregar Nueva Imagen

**Botón**: "Subir Imagen" (botón primario en la parte superior)

**Modal**: `#addImageModal`

**Campos**:
- Paciente (solo lectura)
- Título (requerido)
- Descripción (opcional)
- Imagen: Subir archivo o tomar foto

**Flujo**:
1. Hacer clic en "Subir Imagen"
2. Llenar título y descripción
3. Seleccionar imagen:
   - Clic en "Subir Imagen" → seleccionar archivo
   - O "Tomar Foto" → activar cámara
4. Enviar formulario
5. Redirigir al tab de imágenes

**Código JavaScript**:
```javascript
// Evento submit del formulario
imageForm.addEventListener('submit', function(e) {
    // Validación y envío AJAX
    // Redirección a ?tab=images
});
```

### 3. Ver Imagen Completa

**Botón**: "Ver" en cada tarjeta

**Modal**: `#imageModal`

**Contenido**:
- Imagen ampliada (izquierda)
- Información (derecha):
  - Fecha y hora (grande, negrita)
  - Título (gris, pequeño)
  - Descripción (gris)

**Flujo**:
1. Hacer clic en imagen o botón "Ver"
2. Abrir modal con imagen e información
3. Cerrar modal

### 4. Editar Imagen

**Botón**: "Editar" en cada tarjeta

**Modal**: `#editImageModal`

**Campos**:
- Título (requerido)
- Descripción (opcional)
- Imagen: Cambiar imagen (opcional)

**Flujo**:
1. Hacer clic en "Editar"
2. Modificar campos deseados
3. Opcionalmente cambiar imagen
4. Enviar formulario
5. Redirigir al tab de imágenes

**Código JavaScript**:
```javascript
// Configuración del formulario
editForm.action = `/dental_management/patient_images/${imageId}`;

// Envío con _method=PUT
formData.append('_method', 'PUT');
if (editSelectedFile) {
    formData.append('image', editSelectedFile);
}
```

### 5. Eliminar Imagen

**Botón**: "Eliminar" en cada tarjeta

**Modal**: `#deleteImageModal`

**Campos**:
- Motivo de eliminación (requerido, mínimo 10 caracteres)

**Flujo**:
1. Hacer clic en "Eliminar"
2. Ingresar motivo de eliminación
3. Confirmar eliminación
4. Redirigir al tab de imágenes

**Proceso de eliminación**:
1. Marcar imagen como inactiva (`is_active = false`)
2. Soft delete del registro
3. Eliminar archivo físico del servidor

## Validaciones

### Crear/Editar Imagen
- Título: requerido, máximo 255 caracteres
- Descripción: opcional, máximo 1000 caracteres
- Imagen: requerida al crear, opcional al editar
  - Tipos: jpeg, png, jpg, gif
  - Tamaño máximo: 5MB

### Eliminar Imagen
- Motivo: requerido, mínimo 10 caracteres, máximo 500 caracteres

## Manejo de Errores

### Errores Comunes
1. **Imagen no encontrada (404)**: Al editar/eliminar imagen ya eliminada
2. **Archivo no válido**: Tipo o tamaño incorrecto
3. **Permisos insuficientes**: Usuario sin permisos

### Manejo en JavaScript
```javascript
fetch(url, { /* ... */ })
.then(response => {
    if (response.status === 404) {
        throw new Error('La imagen ya no existe o fue eliminada.');
    }
    return response.json();
})
.then(data => {
    // Éxito
})
.catch(error => {
    // Mostrar error
});
```

## Seguridad

### Permisos
- `patient_images.view`: Ver imágenes
- `patient_images.create`: Crear imágenes
- `patient_images.edit`: Editar imágenes
- `patient_images.delete`: Eliminar imágenes

### Validaciones de Propiedad
- Las imágenes solo pueden ser gestionadas por su paciente asociado
- Verificación de ownership en eliminación física

## Base de Datos

### Tabla `patient_images`
```sql
- id: bigint unsigned
- patient_id: bigint unsigned (FK)
- title: varchar(255)
- filename: varchar(255)
- description: text
- is_active: boolean (default true)
- created_by: bigint unsigned (FK)
- deleted_by: bigint unsigned (FK)
- deleted_description: text
- created_at: timestamp
- updated_at: timestamp
- deleted_at: timestamp (soft delete)
```

### Relaciones
- `patient`: belongsTo Patient
- `creator`: belongsTo User (created_by)
- `deleter`: belongsTo User (deleted_by)

## API Endpoints

### Crear Imagen
```http
POST /dental_management/patient_images
Content-Type: multipart/form-data

{
    patient_id: 1,
    title: "Radiografía dental",
    description: "Radiografía panorámica",
    image: [file],
    from_patient: true
}
```

### Actualizar Imagen
```http
POST /dental_management/patient_images/{slug}
Content-Type: multipart/form-data

{
    title: "Nuevo título",
    description: "Nueva descripción",
    image: [file], // opcional
    _method: "PUT",
    from_patient: true
}
```

### Eliminar Imagen
```http
POST /dental_management/patient_images/{slug}

{
    reason: "Motivo de eliminación",
    _method: "DELETE",
    from_patient: true
}
```

## Flujo Completo de Operaciones

### Agregar Imagen
1. Usuario hace clic en "Subir Imagen"
2. Se abre modal con formulario
3. Usuario llena campos y selecciona imagen
4. JavaScript valida y envía vía AJAX
5. Controlador procesa archivo y crea registro
6. Respuesta de éxito redirige a tab de imágenes

### Editar Imagen
1. Usuario hace clic en "Editar" de una imagen
2. Se abre modal con datos actuales
3. Usuario modifica campos
4. JavaScript envía actualización vía AJAX
5. Controlador actualiza registro y archivo si cambió
6. Respuesta de éxito redirige a tab de imágenes

### Eliminar Imagen
1. Usuario hace clic en "Eliminar" de una imagen
2. Se abre modal de confirmación
3. Usuario ingresa motivo
4. JavaScript envía eliminación vía AJAX
5. Controlador marca inactiva, soft delete y elimina archivo
6. Respuesta de éxito redirige a tab de imágenes

## Notas Técnicas

### Soft Delete
- Las imágenes eliminadas permanecen en BD con `deleted_at`
- No se muestran en la interfaz
- Archivo físico se elimina inmediatamente

### Caché de Imágenes
- Las imágenes se sirven desde `storage/app/public/`
- En producción, ejecutar `php artisan storage:link`

### Optimización
- Imágenes se muestran en tarjetas de tamaño fijo (200px height)
- Modal de vista permite zoom con `max-height: 70vh`

### Compatibilidad
- Soporte para webcam via `navigator.mediaDevices.getUserMedia()`
- Fallback para navegadores sin soporte de cámara