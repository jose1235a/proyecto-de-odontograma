# Integración API RENIEC - Consulta Automática de DNI

## 📋 Descripción General

Esta implementación permite la consulta automática de datos personales desde la RENIEC (Registro Nacional de Identificación y Estado Civil) del Perú mediante una API externa. Se integra en los formularios de creación y edición de pacientes y doctores para autocompletar automáticamente los campos de nombre y apellido al ingresar un número de DNI válido.

La funcionalidad se activa automáticamente cuando el usuario sale del campo DNI (evento blur), sin necesidad de presionar botones adicionales.

## 🏗️ Arquitectura de la Solución

### Componentes Principales
1. **API Externa**: apis.net.pe (servicio que consume APIs de RENIEC/SUNAT)
2. **Backend**: Endpoints separados en PatientController y DoctorController
3. **Frontend**: JavaScript automático en formularios con evento blur
4. **Configuración**: Variables de entorno para API key

---

## ⚙️ Paso 1: Configuración de la API

### 1.1 Variables de Entorno (.env)
```env
# SUNAT/RENIEC API Configuration
SUNAT_API_TOKEN=sk_2033.Eac12xNhMS8Y85YxKrKsugdgxBaFDTEC
```

### 1.2 Configuración de Servicios (config/services.php)
```php
<?php
return [
    // ... otros servicios ...

    'sunat' => [
        'api_token' => env('SUNAT_API_TOKEN'),
    ],
];



## 🔧 Paso 2: Backend - Endpoints de Consulta

### 2.1 Rutas (routes/dental_management.php)


// ... otras rutas ...

// DNI Lookup - RENIEC API Integration
Route::post('patients/dni-lookup', [PatientController::class, 'dniLookup'])->name('patients.dni.lookup');
Route::post('doctors/dni-lookup', [DoctorController::class, 'dniLookup'])->name('doctors.dni.lookup');

### 2.2 Controladores

#### PatientController (app/Http/Controllers/DentalManagement/PatientController.php)



namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\PatientService;
use App\Models\Patient;
use App\Http\Requests\DentalManagement\Patient\StoreRequest;
use App\Http\Requests\DentalManagement\Patient\UpdateRequest;
use App\Http\Requests\DentalManagement\Patient\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService
    ) {}

    // ... otros métodos CRUD ...

    /**
     * Consulta DNI en API RENIEC para pacientes
     */
    public function dniLookup(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/',
        ]);

        try {
            $dni = $request->input('dni');
            $apiKey = config('services.sunat_api_token');
            $client = new \GuzzleHttp\Client();
            $response = $client->get("https://api.apis.net.pe/v1/dni?numero={$dni}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);
                if (isset($data['nombres']) && isset($data['apellidoPaterno']) && isset($data['apellidoMaterno'])) {
                    return response()->json([
                        'success' => true,
                        'name' => $data['nombres'],
                        'last_name' => $data['apellidoPaterno'] . ' ' . $data['apellidoMaterno'],
                    ]);
                }
            }

            return response()->json(['success' => false, 'message' => 'No se encontraron datos para este DNI']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al consultar el DNI']);
        }
    }
}


#### DoctorController (app/Http/Controllers/DentalManagement/DoctorController.php)



namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\DoctorService;
use App\Models\Doctor;
use App\Http\Requests\DentalManagement\Doctor\StoreRequest;
use App\Http\Requests\DentalManagement\Doctor\UpdateRequest;
use App\Http\Requests\DentalManagement\Doctor\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function __construct(
        private DoctorService $doctorService
    ) {
        $this->middleware('permission:doctors.view')->only(['index', 'show']);
        $this->middleware('permission:doctors.create')->only(['create', 'store']);
        $this->middleware('permission:doctors.edit')->only(['edit', 'update', 'editAll', 'updateInline']);
        $this->middleware('permission:doctors.delete')->only(['delete', 'deleteSave']);
        $this->middleware('permission:doctors.export')->only(['exportExcel', 'exportPdf', 'exportWord']);
    }

    // ... otros métodos CRUD ...

    /**
     * Consulta DNI en API RENIEC para doctores
     */
    public function dniLookup(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/',
        ]);

        try {
            $dni = $request->input('dni');
            $apiKey = config('services.sunat_api_token');
            $client = new \GuzzleHttp\Client();
            $response = $client->get("https://api.apis.net.pe/v1/dni?numero={$dni}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);
                if (isset($data['nombres']) && isset($data['apellidoPaterno']) && isset($data['apellidoMaterno'])) {
                    return response()->json([
                        'success' => true,
                        'name' => $data['nombres'],
                        'last_name' => $data['apellidoPaterno'] . ' ' . $data['apellidoMaterno'],
                    ]);
                }
            }

            return response()->json(['success' => false, 'message' => 'No se encontraron datos para este DNI']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al consultar el DNI']);
        }
    }
}


## 🎨 Paso 3: Frontend - JavaScript Automático

### 3.1 Estructura de Formularios
---Los formularios incluyen campos para:
- `document_type`: Selector (DNI, Pasaporte, etc.)
- `document`: Campo de texto para el número
- `name`: Campo para nombres
- `last_name`: Campo para apellidos

### 3.2 JavaScript en Formularios de Pacientes

#### Crear Paciente (resources/views/dental_management/patients/create.blade.php)
```php
@push('scripts')
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
</script>
@endpush
```

#### Editar Paciente (resources/views/dental_management/patients/edit.blade.php)
```php
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
</script>
@endpush
```

### 3.5 JavaScript en Formularios de Doctores

#### Crear Doctor (resources/views/dental_management/doctors/create.blade.php)
```php
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
```

#### Editar Doctor (resources/views/dental_management/doctors/edit.blade.php)
```php
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
```

---

## 🔄 Paso 4: Flujo de Funcionamiento

### 4.1 Proceso Automático
1. **Usuario selecciona "DNI"** en el campo `document_type`
2. **Ingresa número de DNI** (8 dígitos) en campo `document`
3. **Evento blur se dispara** automáticamente al salir del campo
4. **Validación automática**:
   - Tipo de documento debe ser "DNI"
   - DNI debe tener exactamente 8 dígitos
   - Solo números permitidos
5. **Consulta API automática** sin intervención del usuario
6. **Autocompletado silencioso** de campos `name` y `last_name`

### 4.2 Formato de Respuesta de API
```json
{
  "success": true,
  "name": "JUAN CARLOS",
  "last_name": "PEREZ GONZALEZ"
}
```

### 4.3 Manejo de Errores
- **DNI no encontrado**: Proceso silencioso, no interrumpe el flujo
- **Error de conexión**: Mensaje silencioso en consola
- **Formato inválido**: No se ejecuta consulta
- **Sin interrupción**: El usuario puede continuar llenando el formulario

---

## 📁 Paso 5: Archivos Modificados

### Backend
- `routes/dental_management.php` - Rutas separadas para pacientes y doctores
- `app/Http/Controllers/DentalManagement/PatientController.php` - Método dniLookup()
- `app/Http/Controllers/DentalManagement/DoctorController.php` - Método dniLookup()

### Configuración
- `.env` - Variable SUNAT_API_TOKEN
- `config/services.php` - Configuración del servicio SUNAT

### Frontend - Pacientes
- `resources/views/dental_management/patients/create.blade.php` - JavaScript automático
- `resources/views/dental_management/patients/edit.blade.php` - JavaScript automático

### Frontend - Doctores
- `resources/views/dental_management/doctors/create.blade.php` - JavaScript automático
- `resources/views/dental_management/doctors/edit.blade.php` - JavaScript automático

---

## ⚡ Paso 6: Características Técnicas

### Automatización Completa
- ✅ **Sin botones**: Se activa automáticamente con blur
- ✅ **Validación automática**: Solo procesa DNIs válidos
- ✅ **Feedback silencioso**: No interrumpe la experiencia del usuario
- ✅ **Manejo de errores**: Robusto y no intrusivo

### Arquitectura Modular
- ✅ **Controladores separados**: Cada entidad maneja su propia lógica
- ✅ **Rutas independientes**: Endpoints específicos por módulo
- ✅ **JavaScript dedicado**: Código específico para cada formulario
- ✅ **Configuración centralizada**: Token en variables de entorno

### Seguridad y Performance
- ✅ **Token seguro**: No hardcodeado en el código
- ✅ **Validación estricta**: Solo DNIs de 8 dígitos numéricos
- ✅ **Rate limiting**: Depende del proveedor de API
- ✅ **Cache de configuración**: Optimización de Laravel

---

## 📋 Paso 7: Requisitos del Sistema

### Dependencias Técnicas
- **Laravel**: Framework PHP 10+
- **Guzzle HTTP**: Cliente HTTP para Laravel
- **jQuery**: Librería JavaScript para AJAX
- **Bootstrap/AdminLTE**: Framework CSS/JS del frontend

### Configuración Requerida
- **Token de API válido**: SUNAT_API_TOKEN en .env
- **Conexión a internet**: Para consultas a API externa
- **Permisos de red**: Acceso a apis.net.pe

### Variables de Entorno
```env
SUNAT_API_TOKEN=tu_token_de_api_aqui
```

---

## 🎯 Paso 8: Ejemplo de Uso

### Escenario: Crear Nuevo Paciente
1. Ir a "Gestión Dental" → "Pacientes" → "Crear"
2. Seleccionar "DNI" en "Tipo de Documento"
3. Ingresar DNI: `12345678`
4. **Automáticamente** se llenan al salir del campo:
   - Nombre: JUAN CARLOS
   - Apellido: PEREZ GONZALEZ

### Respuesta de API de RENIEC
```json
{
  "dni": "12345678",
  "nombres": "JUAN CARLOS",
  "apellidoPaterno": "PEREZ",
  "apellidoMaterno": "GONZALEZ",
  "codVerifica": "1"
}
```

---

## 🔍 Paso 9: Testing y Debugging

### Verificar Funcionamiento
1. **Configurar token**: Asegurar SUNAT_API_TOKEN en .env
2. **Limpiar cache**: `php artisan config:clear`
3. **Probar endpoints**:
   - `POST /dental_management/patients/dni-lookup`
   - `POST /dental_management/doctors/dni-lookup`
4. **Verificar logs**: Errores en consola del navegador

### Debugging Común
- **Network tab**: Verificar peticiones AJAX automáticas
- **Console logs**: Mensajes de error silenciosos
- **Laravel logs**: Errores del backend
- **API response**: Verificar formato de respuesta JSON

---

## 🏆 Paso 10: Beneficios y Mejores Prácticas

### Beneficios Implementados
- ✅ **Experiencia fluida**: Sin clics adicionales requeridos
- ✅ **Automatización completa**: Proceso transparente para el usuario
- ✅ **Validación robusta**: Solo procesa datos válidos
- ✅ **Manejo de errores**: No interrumpe el flujo de trabajo
- ✅ **Arquitectura modular**: Fácil mantenimiento y escalabilidad

### Mejores Prácticas Aplicadas
- ✅ **Separación de responsabilidades**: Cada controlador maneja su entidad
- ✅ **Configuración externa**: Tokens en variables de entorno
- ✅ **Validación estricta**: Seguridad y consistencia de datos
- ✅ **Manejo de excepciones**: Robustez en producción
- ✅ **Documentación completa**: README detallado y actualizado

---

## 🎉 Conclusión

Esta implementación proporciona una integración completa y automática con la API de RENIEC para consulta de DNI, permitiendo autocompletar automáticamente los datos personales en los formularios de pacientes y doctores.

**Características destacadas:**
- 🔄 **Completamente automática**: Se activa con el evento blur
- 🔒 **Segura**: Token en variables de entorno
- 🏗️ **Modular**: Arquitectura limpia y mantenible
- ⚡ **Performante**: Validación y consulta optimizadas
- 📱 **User-friendly**: Experiencia transparente para el usuario

La integración mejora significativamente la experiencia del usuario al reducir el tiempo de llenado de formularios y minimizar errores de tipeo en datos personales, manteniendo una arquitectura robusta y escalable.