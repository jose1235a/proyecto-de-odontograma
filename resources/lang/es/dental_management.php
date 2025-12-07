<?php



return [

    'patients' => [

        'title' => 'Pacientes',

        'plural' => 'Pacientes',

        'create' => 'Crear Paciente',

        'create_title' => 'Crear Paciente',

        'edit' => 'Editar Paciente',

        'edit_title' => 'Editar Paciente',

        'show' => 'Detalles del Paciente',

        'show_title' => 'Detalles del Paciente',

        'info_title' => 'Información del Paciente',
        'delete' => 'Eliminar Paciente',

        'delete_title' => 'Eliminar Paciente',

        'edit_all_title' => 'Editar Todos los Pacientes',

        'id' => 'N°',

        'photo' => 'Foto',

        'document_type' => 'Tipo de Documento',

        'document' => 'Documento',

        'name' => 'Nombre',

        'last_name' => 'Apellidos',

        'email' => 'Correo Electrónico',

        'phone' => 'Teléfono',

        'gender' => 'Género',

        'age' => 'Edad',

        'allergy' => 'Alergia',

        'is_active' => 'Estado',

        'birth_date' => 'Fecha de Nacimiento',

        'address' => 'Dirección',

        'emergency_contact' => 'Contacto de Emergencia',

        'medical_history' => 'Historial Médico',

        'medical_history_title' => 'Antecedentes Médicos',

        'under_medical_treatment' => 'Bajo Tratamiento Médico',

        'prone_to_bleeding' => 'Propenso a Hemorragia',

        'allergic_to_medication' => 'Alérgico a Medicamentos',

        'hypertensive' => 'Hipertenso',

        'diabetic' => 'Diabético',

        'pregnant' => 'Embarazada',
        'images' => 'Imágenes',
        'total_debt' => 'Deuda total',
        'no_debt' => 'Sin deuda',
        'conditions' => [
            'under_medical_treatment' => 'Bajo tratamiento médico',
            'prone_to_bleeding' => 'Propenso a sangrado',
            'allergic_to_medication' => 'Alérgico a medicamentos',
            'hypertensive' => 'Hipertenso',
            'diabetic' => 'Diabético',
            'pregnant' => 'Embarazada',
        ],

        'consultation_reason' => 'Motivo de Consulta',

        'diagnosis' => 'Diagnóstico',

        'observations' => 'Observaciones',

        'referred_by' => 'Referido por',

        'warning_conditions' => 'Advertencia: el paciente es:',

        'description_placeholder' => 'Ingrese una descripción detallada',

        'photo_help' => 'Selecciona una imagen desde tu dispositivo.',

        'current_photo' => 'Foto actual',

        'take_photo' => 'Tomar Foto',

        'take_photo_help' => 'Toma una foto usando la cámara de tu dispositivo.',

        'export_filename' => 'Pacientes',

        'first_consultation' => 'Primera Consulta',

        'first_consultation_title' => 'Historial Clinico',

        'consultation_date' => 'Fecha de Consulta',

        'consultation_time' => 'Hora de Consulta',

        'consultation_description' => 'Descripción de la Consulta',

        'fever' => 'Temperatura (Fiebre)',

        'blood_pressure' => 'Presión Arterial',

        'consultation_cost' => 'Costo de la Consulta',

        'upload_image' => 'Subir imagen',

        'fields' => [

            'document_type' => 'Tipo de Documento',

            'document' => 'Documento',

            'name' => 'Nombre',

            'last_name' => 'Apellidos',

            'email' => 'Correo Electrónico',

            'phone' => 'Teléfono',

            'address' => 'Dirección',

            'birth_date' => 'Fecha de Nacimiento',

            'consultation_reason' => 'Motivo de Consulta',

            'diagnosis' => 'Diagnóstico',

            'observations' => 'Observaciones',

            'referred_by' => 'Referido por',

            'emergency_contact' => 'Contacto de Emergencia',

            'delete_reason' => 'Motivo de Eliminación',

        ],

        'validation' => [

            'document_type_required' => 'El tipo de documento es obligatorio.',

            'document_type_invalid' => 'El tipo de documento seleccionado no es válido.',

            'document_required' => 'El documento es obligatorio.',

            'document_unique' => 'Este documento ya está registrado.',

            'name_required' => 'El nombre es obligatorio.',

            'last_name_required' => 'Los apellidos son obligatorios.',

            'email_required' => 'El correo electrónico es obligatorio.',

            'email_invalid' => 'El correo electrónico no es válido.',

            'email_unique' => 'Este correo electrónico ya está registrado.',

            'phone_required' => 'El teléfono es obligatorio.',

            'birth_date_invalid' => 'La fecha de nacimiento no es válida.',

            'birth_date_before' => 'La fecha de nacimiento debe ser anterior a hoy.',

            'delete_reason_required' => 'El motivo de eliminación es obligatorio.',

            'delete_reason_min' => 'El motivo debe tener al menos 10 caracteres.',

            'delete_reason_max' => 'El motivo no puede exceder 500 caracteres.',

        ],

    ],

    'specialties' => [

        'title' => 'Especialidades',

        'plural' => 'Especialidades',

        'create' => 'Crear Especialidad',

        'create_title' => 'Crear Especialidad',

        'edit' => 'Editar Especialidad',

        'edit_title' => 'Editar Especialidad',

        'show' => 'Detalles de Especialidad',

        'show_title' => 'Detalles de Especialidad',

        'delete' => 'Eliminar Especialidad',

        'delete_title' => 'Eliminar Especialidad',

        'edit_all_title' => 'Editar Todas las Especialidades',

        'id' => 'N°',

        'name' => 'Nombre',

        'description' => 'Descripción',

        'is_active' => 'Estado',

        'export_filename' => 'Especialidades',

        'fields' => [

            'name' => 'Nombre',

            'description' => 'Descripción',

            'is_active' => 'Estado',

            'delete_reason' => 'Motivo de Eliminación',

        ],

        'validation' => [

            'name_required' => 'El nombre es obligatorio.',

            'name_unique' => 'Este nombre ya está registrado.',

            'name_max' => 'El nombre no puede exceder 255 caracteres.',

            'delete_reason_required' => 'El motivo de eliminación es obligatorio.',

            'delete_reason_min' => 'El motivo debe tener al menos 10 caracteres.',

            'delete_reason_max' => 'El motivo no puede exceder 500 caracteres.',

        ],

    ],

    'doctors' => [

        'title' => 'Doctores',

        'plural' => 'Doctores',

        'singular' => 'Doctor',

        'create' => 'Crear Doctor',

        'create_title' => 'Crear Doctor',

        'edit' => 'Editar Doctor',

        'edit_title' => 'Editar Doctor',

        'show' => 'Detalles del Doctor',

        'show_title' => 'Detalles del Doctor',

        'delete' => 'Eliminar Doctor',

        'delete_title' => 'Eliminar Doctor',

        'edit_all_title' => 'Editar Todos los Doctores',

        'id' => 'N°',

        'document_type' => 'Tipo de Documento',

        'document' => 'Documento',

        'name' => 'Nombre',

        'last_name' => 'Apellidos',

        'gender' => 'Sexo',

        'email' => 'Correo Electrónico',

        'phone' => 'Teléfono',

        'address' => 'Dirección',

        'specialty' => 'Especialidad',

        'is_active' => 'Estado',

        'export_filename' => 'Doctores',

        'fields' => [

            'name' => 'Nombre',

            'last_name' => 'Apellidos',

            'gender' => 'Género',

            'email' => 'Correo Electrónico',

            'phone' => 'Teléfono',

            'specialty' => 'Especialidad',

            'delete_reason' => 'Motivo de Eliminación',

        ],

        'validation' => [

            'document_type_required' => 'El tipo de documento es obligatorio.',

            'document_type_invalid' => 'El tipo de documento seleccionado no es válido.',

            'document_required' => 'El documento es obligatorio.',

            'document_unique' => 'Este documento ya está registrado.',

            'name_required' => 'El nombre es obligatorio.',

            'last_name_required' => 'Los apellidos son obligatorios.',

            'email_required' => 'El correo electrónico es obligatorio.',

            'email_invalid' => 'El correo electrónico no es válido.',

            'email_unique' => 'Este correo electrónico ya está registrado.',

            'phone_required' => 'El teléfono es obligatorio.',

            'specialty_required' => 'La especialidad es obligatoria.',

            'specialty_exists' => 'La especialidad seleccionada no existe.',

            'delete_reason_required' => 'El motivo de eliminación es obligatorio.',

            'delete_reason_min' => 'El motivo debe tener al menos 10 caracteres.',

            'delete_reason_max' => 'El motivo no puede exceder 500 caracteres.',

        ],

    ],

    'treatments' => [

        'title' => 'Tratamientos',

        'plural' => 'Tratamientos',

        'singular' => 'Tratamiento',

        'create' => 'Crear Tratamiento',

        'create_title' => 'Crear Tratamiento',

        'edit' => 'Editar Tratamiento',

        'edit_title' => 'Editar Tratamiento',

        'show' => 'Detalles del Tratamiento',

        'show_title' => 'Detalles del Tratamiento',

        'delete' => 'Eliminar Tratamiento',

        'delete_title' => 'Eliminar Tratamiento',

        'name' => 'Nombre',

        'description' => 'Descripción',

        'cost' => 'Costo',

        'coverage' => 'Cobertura',
        'color' => 'Color',

        'cost_min' => 'Costo mínimo',

        'cost_max' => 'Costo máximo',

        'is_active' => 'Estado',

        'edit_all_title' => 'Editar Todos los Tratamientos',

        'export_filename' => 'Tratamientos',

        'fields' => [

            'name' => 'Nombre',

            'description' => 'Descripción',

            'cost' => 'Costo',

            'coverage' => 'Cobertura',

        ],

        'coverage_partial' => 'Cobertura parcial',

        'coverage_full' => 'Cobertura completa',

        'validation' => [

            'name_required' => 'El nombre es obligatorio.',

            'name_unique' => 'Este nombre ya está registrado.',

            'description_max' => 'La descripción no puede exceder 1000 caracteres.',

            'cost_required' => 'El costo es obligatorio.',

            'cost_numeric' => 'El costo debe ser un valor numérico.',

            'cost_min' => 'El costo debe ser al menos 0.',

            'cost_max' => 'El costo no puede exceder 999999.99.',

            'coverage_required' => 'La cobertura es obligatoria.',

            'coverage_invalid' => 'La cobertura seleccionada no es válida.',

        ],

    ],

    'appointments' => [

        'title' => 'Citas',

        'plural' => 'Citas',

        'create_title' => 'Crear Cita',

        'edit_title' => 'Editar Cita',

        'show_title' => 'Detalles de la Cita',

        'delete_title' => 'Eliminar Cita',

        'edit_all_title' => 'Editar Todas las Citas',

        'create' => 'Crear Cita',

        'edit' => 'Editar Cita',

        'show' => 'Detalles de la Cita',

        'delete' => 'Eliminar Cita',

        'patient' => 'Paciente',

        'patient_document' => 'Documento del Paciente',

        'patient_preselected' => 'Paciente preseleccionado desde la vista de detalles',

        'doctor' => 'Doctor',

        'treatment' => 'Tratamiento',

        'date' => 'Fecha',

        'time' => 'Hora',

        'appointment_date' => 'Fecha de la Cita',

        'appointment_time' => 'Hora de la Cita',

        'status' => 'Estado',

        'disease' => 'Enfermedad',

        'cost' => 'Costo',

        'paid' => 'Pagado',

        'notes' => 'Notas',

        'status_assigned' => 'Asignado',

        'status_attended' => 'Atendido',

        'status_cancelled' => 'Cancelado',

        'export_filename' => 'Citas',

        'fields' => [

            'patient' => 'Paciente',

            'doctor' => 'Doctor',

            'treatment' => 'Tratamiento',

            'date' => 'Fecha',

            'time' => 'Hora',

            'appointment_date' => 'Fecha de la Cita',

            'appointment_time' => 'Hora de la Cita',

            'status' => 'Estado',

            'disease' => 'Enfermedad',

            'cost' => 'Costo',

            'paid' => 'Pagado',

            'patient_document' => 'Documento del Paciente',

        ],

        'messages' => [

            'patient_not_found' => 'No se encontró un paciente con ese documento.',

            'patient_found' => 'Paciente seleccionado correctamente.',

            'patient_search_help' => 'Ingresa el documento del paciente y presiona buscar.',

        ],

        'validation' => [

            'patient_required' => 'El paciente es obligatorio.',

            'patient_exists' => 'El paciente seleccionado no existe.',

            'doctor_required' => 'El doctor es obligatorio.',

            'doctor_exists' => 'El doctor seleccionado no existe.',

            'treatment_required' => 'El tratamiento es obligatorio.',

            'treatment_exists' => 'El tratamiento seleccionado no existe.',

            'date_required' => 'La fecha de la cita es obligatoria.',

            'date_not_past' => 'La fecha de la cita no puede ser anterior a hoy.',

            'time_required' => 'La hora de la cita es obligatoria.',

            'time_format' => 'La hora debe tener el formato HH:MM.',

            'disease_required' => 'La enfermedad es obligatoria.',

            'cost_required' => 'El costo es obligatorio.',

            'cost_numeric' => 'El costo debe ser un valor numérico.',

            'paid_required' => 'El monto pagado es obligatorio.',

            

            'overlap' => 'Ya existe otra cita programada para este paciente en un intervalo de 15 minutos. Ajusta la hora.',

        ],

    ],

    'odontogram' => [

        'title' => 'Odontograma',

        'singular' => 'Odontograma',

        'plural' => 'Odontogramas',

        'index' => 'Lista de Odontogramas',

        'create' => 'Crear Odontograma',

        'create_title' => 'Crear Odontograma',

        'store' => 'Guardar Odontograma',

        'edit' => 'Editar Odontograma',

        'edit_title' => 'Editar Odontograma',

        'show' => 'Detalles del Odontograma',

        'show_title' => 'Detalles del Odontograma',

        'delete' => 'Eliminar Odontograma',

        'delete_title' => 'Eliminar Odontograma',

        'patient' => 'Paciente',

        'doctor' => 'Doctor',

        'state' => 'Estado',

        'date_procedure' => 'Fecha del Procedimiento',

        'description' => 'Descripción',

        'patient_placeholder' => 'Selecciona un paciente',

        'doctor_placeholder' => 'Selecciona un doctor',

        'odontogram_editor' => 'Editor de Odontograma',

        'reset' => 'Reiniciar',

        'reset_zoom' => 'Reiniciar zoom',

        'legend' => 'Leyenda',

        'selected_tooth_title' => 'Diente seleccionado',

        'selected_tooth_label' => 'Diente',

        'tooth_label' => 'Diente',

        'current_treatment_data' => 'Datos del tratamiento',

        'summary_tooth' => 'Diente tratado',

        'summary_surface' => 'Cara tratada',

        'summary_state' => 'Tratamiento',

        'applied_treatments' => 'Tratamientos registrados',

        'session_treatments_empty' => 'Aún no se han agregado tratamientos.',

        'full_tooth' => 'Pieza completa',
        'surface_whole_tooth' => 'Pieza completa',

        'save_action' => 'Guardar acción',

        'clear_selection' => 'Limpiar selección',

        'advanced_options' => 'Opciones avanzadas',

        'advanced_options_title' => 'Opciones avanzadas - Editar colores de tratamientos',

        'tools_title' => 'Herramientas',

        'tool_cavity' => 'Caries',

        'tool_cavity_desc' => 'Marca una caries en la pieza seleccionada',

        'tool_filling' => 'Relleno',

        'tool_filling_desc' => 'Marca un relleno en la pieza seleccionada',

        'tool_crown' => 'Corona',

        'tool_crown_desc' => 'Marca una corona en la pieza seleccionada',

        'tool_extraction' => 'Extracción',

        'tool_extraction_desc' => 'Marca la pieza como extraída',

        'tool_implant' => 'Implante',

        'tool_implant_desc' => 'Marca un implante en la pieza seleccionada',

        'tool_clear' => 'Limpiar',

        'tool_clear_desc' => 'Elimina la marca de la pieza seleccionada',

        'canvas_instructions' => 'Haz clic en una pieza dental para aplicar una herramienta.',

        'click_instruction' => 'Selecciona una herramienta y luego una pieza dental para registrar el procedimiento.',

        'patient_odontogram_title' => 'Odontograma del Paciente',

        'history_title' => 'Historial de registros',

        'treatment_history_title' => 'Historial de Tratamiento',

        'history_description' => 'Descripción',

        'history_registered' => 'Registrado',

        'history_updated' => 'Registro actualizado correctamente.',
        'history_edit' => 'Editar registro',
        'history_edit_title' => 'Editar registro del historial',
        'history_edit_doctor' => 'Doctor',
        'history_edit_description' => 'Descripción',

        'history_deleted' => 'Registro eliminado correctamente.',

        'history_delete_confirm' => '¿Estás seguro de que deseas eliminar este registro del historial?',

        'surfaces' => [

            'top' => 'Arriba',

            'right' => 'Derecha',

            'bottom' => 'Abajo',

            'left' => 'Izquierda',

            'center' => 'Centro',

        ],


        'action_saved' => 'Acción guardada correctamente.',

        'action_save_error' => 'Ocurrió un error al guardar la acción. Intenta nuevamente.',

        'validation' => [

            'patient_required' => 'El paciente es obligatorio.',

            'patient_exists' => 'El paciente seleccionado no existe.',

            'doctor_required' => 'El doctor es obligatorio.',

            'doctor_exists' => 'El doctor seleccionado no existe.',

            'description_required' => 'La descripción es obligatoria.',

            'description_max' => 'La descripción no puede exceder 1000 caracteres.',

            'date_procedure_invalid' => 'La fecha del procedimiento no es válida.',

            'odontogram_data_required' => 'El detalle del odontograma es obligatorio.',

            'odontogram_data_invalid' => 'El detalle del odontograma debe ser un JSON válido.',

            'delete_reason_required' => 'El motivo de eliminación es obligatorio.',

            'delete_reason_min' => 'El motivo debe tener al menos 10 caracteres.',

            'delete_reason_max' => 'El motivo no puede exceder 500 caracteres.',
            'consultation_time_required' => 'La hora de consulta es obligatoria.',
            'consultation_description_required' => 'La descripción de la consulta es obligatoria.',

        ],

    ],

    'appointment_history' => [

        'title' => 'Historial de Citas',

        'patient' => 'Paciente',

        'doctor' => 'Doctor',

        'date' => 'Fecha',

        'treatment' => 'Tratamiento',

        'notes' => 'Notas',

        'outcome' => 'Resultado',

    ],

    'treatment_history' => [

        'title' => 'Historial de Tratamientos',

        'tooth_number' => 'Número de Diente',

        'surface' => 'Superficie',

        'treatment_type' => 'Tipo de Tratamiento',

        'action' => 'Acción',

        'doctor' => 'Doctor',

        'treatment_date' => 'Fecha de Tratamiento',

        'action_applied' => 'Registrado',

        'action_cleared' => 'Eliminado',

        'saved' => 'Historial de tratamiento guardado correctamente.',

    ],

    'calendar' => [

        'title' => 'Calendario',

        'plural' => 'Calendario',

        'event_details' => 'Detalles de la Cita',

        'patient' => 'Paciente',

        'doctor' => 'Doctor',

        'treatment' => 'Tratamiento',

        'disease' => 'Enfermedad',

        'time' => 'Hora',

        'status' => 'Estado',

        'notes' => 'Notas',

        'today' => 'Hoy',

        'month' => 'Mes',

        'week' => 'Semana',

        'day' => 'Día',

        'button_today' => 'Hoy',

        'button_month' => 'Mes',

        'button_week' => 'Semana',

        'button_day' => 'Día',

        'button_list' => 'Lista',

    ],

    'payments' => [

        'title' => 'Pagos',

        'plural' => 'Pagos',

        'singular' => 'Pago',

        'create' => 'Crear Pago',

        'create_title' => 'Crear Pago',

        'edit' => 'Editar Pago',

        'edit_title' => 'Editar Pago',

        'show' => 'Detalles del Pago',

        'show_title' => 'Detalles del Pago',

        'delete' => 'Eliminar Pago',

        'delete_title' => 'Eliminar Pago',

        'delete_warning' => '¿Está seguro de que desea eliminar este pago? Esta acción no se puede deshacer.',
        'id' => 'N°',

        'patient' => 'Paciente',

        'appointment' => 'Cita',

        'amount' => 'Monto',

        'payment_date' => 'Fecha de Pago',

        'payment_method' => 'Método de Pago',

        'status' => 'Estado',

        'reference_number' => 'Número de Referencia',

        'notes' => 'Notas',

        'treatment' => 'Tratamiento',

        'created_at' => 'Fecha de Creación',

        'methods' => [

            'cash' => 'Efectivo',

            'card' => 'Tarjeta',

            'transfer' => 'Transferencia Bancaria',

            'check' => 'Cheque',

        ],

        'status' => [

            'pending' => 'Pendiente',

            'completed' => 'Completado',

            'cancelled' => 'Cancelado',

            'refunded' => 'Reembolsado',

        ],

        'fields' => [

            'patient' => 'Paciente',

            'appointment' => 'Cita',

            'amount' => 'Monto',

            'payment_date' => 'Fecha de Pago',

            'payment_method' => 'Método de Pago',

            'status' => 'Estado',

            'reference_number' => 'Número de Referencia',

            'notes' => 'Notas',

            'delete_reason' => 'Motivo de Eliminación',

        ],

        'validation' => [

            'patient_required' => 'El paciente es obligatorio.',

            'patient_exists' => 'El paciente seleccionado no existe.',

            'appointment_exists' => 'La cita seleccionada no existe.',

            'amount_required' => 'El monto es obligatorio.',

            'amount_numeric' => 'El monto debe ser un número válido.',

            'amount_min' => 'El monto debe ser mayor a 0.01.',

            'amount_max' => 'El monto no puede exceder 999,999.99.',

            'payment_date_required' => 'La fecha de pago es obligatoria.',

            'payment_date_invalid' => 'La fecha de pago no es válida.',

            'payment_date_future' => 'La fecha de pago no puede ser futura.',

            'payment_method_required' => 'El método de pago es obligatorio.',

            'payment_method_invalid' => 'El método de pago seleccionado no es válido.',

            'status_required' => 'El estado es obligatorio.',

            'status_invalid' => 'El estado seleccionado no es válido.',

            'reference_max' => 'El número de referencia no puede exceder 50 caracteres.',

            'notes_max' => 'Las notas no pueden exceder 500 caracteres.',

            'delete_reason_required' => 'El motivo de eliminación es obligatorio.',

            'delete_reason_min' => 'El motivo debe tener al menos 10 caracteres.',

            'delete_reason_max' => 'El motivo no puede exceder 500 caracteres.',

        ],

    ],

    'reports' => [

        'title' => 'Reportes',

        'plural' => 'Reportes',

        'create' => 'Create Report',

        'create_title' => 'Create Report',

        'edit' => 'Edit Report',

        'edit_title' => 'Edit Report',

        'show' => 'Report Details',

        'show_title' => 'Report Details',

        'delete' => 'Delete Report',

        'delete_title' => 'Delete Report',

        'generate' => 'Generate Report',

        'patient_report' => 'Patient Report',

        'patients_report' => 'Patient Report',

        'appointment_report' => 'Appointment Report',

        'appointments_report' => 'Appointment Report',

        'payment_report' => 'Payment Report',

        'payments_report' => 'Payment Report',

        'treatment_report' => 'Treatment Report',

        'date_range' => 'Date Range',

        'from_date' => 'From Date',

        'to_date' => 'To Date',

        'export_excel' => 'Export to Excel',

        'export_pdf' => 'Export to PDF',

        'export_word' => 'Export to Word',

        'filters' => 'Filters',

        'results' => 'Results',

        'total_records' => 'Total Records',

        'generated_at' => 'Generated at',

        'period' => 'Period',

        'summary' => 'Summary',

        'detailed' => 'Detailed',

        'monthly' => 'Monthly',

        'yearly' => 'Yearly',

        'custom' => 'Custom',

        'no_data' => 'No data available for the selected period.',

        'processing' => 'Processing report...',

        'download_ready' => 'Download ready',

        'download_error' => 'Error generating report',

        'total_patients' => 'Total Patients',

        'total_appointments' => 'Total Appointments',

        'total_revenue' => 'Total Revenue',

        'total_amount' => 'Total Amount',

        'total_payments' => 'Total Payments',

        'appointments_today' => 'Appointments Today',

        'active_patients' => 'Active Patients',

        'patients_with_appointments' => 'Patients with Appointments',

        'patients_with_payments' => 'Patients with Payments',

        'payments_by_method' => 'Payments by Method',

        'payment_methods_summary' => 'Payment Methods Summary',

        'appointments_report_desc' => 'View all scheduled and completed appointments.',

        'payments_report_desc' => 'View all payments made for treatments.',

        'patients_report_desc' => 'View detailed information of all patients.',

    ],

    'consultations' => [

        'title' => 'Consultas',

        'plural' => 'Consultas',

        'singular' => 'Consulta',

        'create' => 'Crear Consulta',

        'create_title' => 'Crear Consulta',

        'edit' => 'Editar Consulta',

        'edit_title' => 'Editar Consulta',

        'show' => 'Detalles de la Consulta',

        'show_title' => 'Detalles de la Consulta',

        'delete' => 'Eliminar Consulta',

        'delete_title' => 'Eliminar Consulta',

        'edit_all_title' => 'Editar Todas las Consultas',

        'clinical_history' => 'Historial de Consultas',

        'new_consultation' => 'Nueva Consulta',

        'no_consultations' => 'No hay consultas registradas',

        'id' => 'N°',

        'patient' => 'Paciente',

        'treatment_id' => 'Tratamiento',

        'treatment' => 'Motivo',

        'doctor_id' => 'Doctor',

        'doctor' => 'Médico',

        'consultation_date' => 'Fecha',

        'consultation_time' => 'Hora',

        'cost' => 'Costo',

        'fever' => 'Fiebre',

        'blood_pressure' => 'Presión',

        'description' => 'Descripción',

        'is_active' => 'Estado',

        'export_filename' => 'Consultas',

        'fields' => [

            'patient' => 'Paciente',

            'treatment' => 'Tratamiento',

            'doctor' => 'Médico',

            'consultation_date' => 'Fecha de Consulta',

            'consultation_time' => 'Hora de Consulta',

            'cost' => 'Costo',

            'description' => 'Descripción',

            'fever' => 'Fiebre',

            'blood_pressure' => 'Presión Sanguínea',

            'is_active' => 'Estado',

            'delete_reason' => 'Motivo de Eliminación',

        ],

        'validation' => [

            'patient_required' => 'Patient is required.',

            'patient_exists' => 'The selected patient does not exist.',

            'treatment_required' => 'The consultation reason is required.',

            'treatment_exists' => 'The selected treatment does not exist.',

            'doctor_required' => 'Doctor is required.',

            'doctor_exists' => 'The selected doctor does not exist.',

            'consultation_date_required' => 'Consultation date is required.',

            'consultation_date_invalid' => 'Consultation date is invalid.',

            'consultation_date_future' => 'Consultation date cannot be in the future.',

            'consultation_time_invalid' => 'Consultation time is invalid.',

            'cost_required' => 'Cost is required.',

            'cost_numeric' => 'Cost must be numeric.',

            'cost_min' => 'Cost must be at least 0.',

            'cost_max' => 'Cost may not exceed 999999.99.',

            'description_max' => 'Description may not exceed 1000 characters.',

            'fever_numeric' => 'Fever must be numeric.',

            'fever_min' => 'Fever must be at least 30°C.',

            'fever_max' => 'Fever may not exceed 45°C.',

            'blood_pressure_max' => 'Blood pressure may not exceed 20 characters.',

            'delete_reason_required' => 'Delete reason is required.',

            'delete_reason_min' => 'Delete reason must have at least 10 characters.',

            'delete_reason_max' => 'Delete reason may not exceed 500 characters.',

        ],

    ],

    'summary' => [

        'title' => 'Resumen',

        'total_patients' => 'Total de Pacientes',

        'total_appointments' => 'Total de Citas',

        'total_payments' => 'Total de Pagos',

        'monthly_revenue' => 'Ingresos Mensuales',

        'pending_appointments' => 'Citas Pendientes',

        'completed_treatments' => 'Tratamientos Completados',

    ],

    'patient_images' => [

        'title' => 'Imágenes del Paciente',

        'plural' => 'Imágenes',

        'create' => 'Crear Imagen',

        'edit' => 'Editar Imagen',

        'delete' => 'Eliminar Imagen',

        'create_title' => 'Crear Imagen de Paciente',

        'no_images' => 'No hay imágenes para el paciente :patient.',

        'patient_id' => 'Paciente',

        'image' => 'Imagen',

        'description' => 'Descripción',

        'description_placeholder' => 'Ingresa una descripción para la imagen',

        'current_image' => 'Imagen Actual',

        'new_image_optional' => 'Nueva Imagen (Opcional)',

        'fields' => [

            'patient' => 'Paciente',

            'title' => 'Título',

            'description' => 'Descripción',

            'date' => 'Fecha',

            'delete_reason' => 'Motivo de eliminación',

            'delete_reason_placeholder' => 'Explique por qué elimina esta imagen...',

        ],

        'title_label' => 'Título',

        'validation' => [

            'patient_required' => 'El paciente es obligatorio.',

            'patient_exists' => 'El paciente seleccionado no existe.',

            'title_required' => 'El título es obligatorio.',

            'title_max' => 'El título no puede exceder 255 caracteres.',

            'image_required' => 'Debe proporcionar una imagen o tomar una foto.',

            'image_image' => 'El archivo debe ser una imagen.',

            'image_mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',

            'image_max' => 'La imagen no puede ser mayor a 5MB.',

            'description_max' => 'La descripción no puede exceder 1000 caracteres.',

            'delete_reason_required' => 'El motivo de eliminación es obligatorio.',

            'delete_reason_min' => 'El motivo debe tener al menos 10 caracteres.',

            'delete_reason_max' => 'El motivo no puede exceder 500 caracteres.',

        ],

    ],

    'payments' => [

        'title' => 'Pagos',

        'plural' => 'Pagos',

        'singular' => 'Pago',

        'create' => 'Crear Pago',

        'create_title' => 'Crear Pago',

        'edit' => 'Editar Pago',

        'edit_title' => 'Editar Pago',

        'show' => 'Detalles del Pago',

        'show_title' => 'Detalles del Pago',

        'delete' => 'Eliminar Pago',

        'delete_title' => 'Eliminar Pago',

        'delete_warning' => '¿Está seguro de que desea eliminar este pago? Esta acción no se puede deshacer.',

        'id' => 'N°',

        'patient' => 'Paciente',

        'appointment' => 'Cita',

        'amount' => 'Monto',

        'payment_date' => 'Fecha de Pago',

        'payment_method' => 'Método de Pago',

        'status' => 'Estado',

        'reference_number' => 'Número de Referencia',

        'notes' => 'Notas',

        'treatment' => 'Tratamiento',

        'created_at' => 'Fecha de Creación',

        'results' => 'Resultados',

        'methods' => [

            'cash' => 'Efectivo',

            'card' => 'Tarjeta',

            'transfer' => 'Transferencia Bancaria',

            'check' => 'Cheque',

        ],

        'status' => [

            'pending' => 'Pendiente',

            'completed' => 'Completado',

            'cancelled' => 'Cancelado',

            'refunded' => 'Reembolsado',

        ],

        'status_values' => [

            'pending' => 'Pendiente',

            'completed' => 'Completado',

            'cancelled' => 'Cancelado',

            'refunded' => 'Reembolsado',

        ],

        'fields' => [

            'patient' => 'Paciente',

            'appointment' => 'Cita',

            'amount' => 'Monto',

            'payment_date' => 'Fecha de Pago',

            'payment_method' => 'Método de Pago',

            'status' => 'Estado',

            'reference_number' => 'Número de Referencia',

            'notes' => 'Notas',

            'delete_reason' => 'Motivo de Eliminación',

        ],

        'validation' => [

            'patient_required' => 'El paciente es obligatorio.',

            'patient_exists' => 'El paciente seleccionado no existe.',

            'appointment_exists' => 'La cita seleccionada no existe.',

            'amount_required' => 'El monto es obligatorio.',

            'amount_numeric' => 'El monto debe ser un número válido.',

            'amount_min' => 'El monto debe ser mayor a 0.01.',

            'amount_max' => 'El monto no puede exceder 999,999.99.',

            'payment_date_required' => 'La fecha de pago es obligatoria.',

            'payment_date_invalid' => 'La fecha de pago no es válida.',

            'payment_date_future' => 'La fecha de pago no puede ser futura.',

            'payment_method_required' => 'El método de pago es obligatorio.',

            'payment_method_invalid' => 'El método de pago seleccionado no es válido.',

            'status_required' => 'El estado es obligatorio.',

            'status_invalid' => 'El estado seleccionado no es válido.',

            'reference_max' => 'El número de referencia no puede exceder 50 caracteres.',

            'notes_max' => 'Las notas no pueden exceder 500 caracteres.',

            'delete_reason_required' => 'El motivo de eliminación es obligatorio.',

            'delete_reason_min' => 'El motivo debe tener al menos 10 caracteres.',

            'delete_reason_max' => 'El motivo no puede exceder 500 caracteres.',

        ],

    ],

];


