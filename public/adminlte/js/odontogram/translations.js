export const DEFAULT_TRANSLATIONS = {
    toothLabel: 'Tooth',
    actionSaved: 'Action saved.',
    actionError: 'An error occurred while saving.',
    surfaceLabels: {},
    legacyTreatmentLabels: {},
    errorTitle: 'Error',
    errorOccurred: 'An error occurred',
    successTitle: 'Success',
    noRecords: 'No records',
    doctorNotSpecified: 'Doctor not specified',
    surfaceWholeTooth: 'Whole tooth',
    sessionTreatmentsEmpty: 'No treatments applied in this session',
    fullTooth: 'Full tooth',
    clickInstruction: 'Select a tool and then a tooth to register the procedure.',
    patientOdontogramTitle: 'Patient Odontogram',
    historyTitle: 'History Records',
    historyRegistered: 'Registered',
    historyDescription: 'Description',
    doctor: 'Doctor',
    reset: 'Reset',
    legend: 'Legend',
    saveAction: 'Save Action',
    clearSelection: 'Clear Selection',
    advancedOptions: 'Advanced Options',
    appliedTreatments: 'Applied Treatments',
    summaryTooth: 'Tooth',
    summarySurface: 'Surface',
    summaryState: 'State',
    odontogramEditor: 'Odontogram Editor',
    selectedToothTitle: 'Selected Tooth',
    selectedToothLabel: 'Selected Tooth: ',
    selectedToothInfo: 'Tooth information',
    treatments: 'Treatments',
    create: 'Create',
    edit: 'Edit',
    delete: 'Delete',
    back: 'Back',
    cancel: 'Cancel',
    save: 'Save',
    update: 'Update',
    show: 'Show',
    index: 'List',
    resetZoom: 'Reset Zoom',
    zoomIn: 'Zoom In',
    zoomOut: 'Zoom Out',
    REQUEST_FAILED: 'Request failed',
    historyDeleted: 'History record deleted successfully',
    validation: {
        odontogram_data_invalid: 'Odontogram data is invalid',
        odontogram_data_required: 'Odontogram data is required',
        patient_required: 'Patient is required',
        doctor_required: 'Doctor is required',
        description_required: 'Description is required',
        delete_reason_required: 'Delete reason is required'
    },
    surfaces: {
        top: 'Top',
        right: 'Right',
        bottom: 'Bottom',
        left: 'Left',
        center: 'Center'
    },
    conditions: {
        cavity: 'Cavity',
        filling: 'Filling',
        crown: 'Crown',
        extraction: 'Extraction',
        implant: 'Implant',
        bridge: 'Bridge',
        healthy: 'Healthy'
    }
};

let runtimeTranslations = { ...DEFAULT_TRANSLATIONS };

function resolveValue(source, key) {
    if (!source || typeof source !== 'object') {
        return undefined;
    }
    if (Object.prototype.hasOwnProperty.call(source, key)) {
        return source[key];
    }
    return undefined;
}

/**
 * Devuelve una traducción individual usando los valores hidratados.
 */
export function getTranslation(key, fallback = '') {
    if (!key) {
        return fallback;
    }

    const runtimeValue = resolveValue(runtimeTranslations, key);
    if (runtimeValue !== undefined) {
        return runtimeValue;
    }

    const defaultValue = resolveValue(DEFAULT_TRANSLATIONS, key);
    if (defaultValue !== undefined) {
        return defaultValue;
    }

    return fallback;
}

/**
 * Mezcla traducciones y actualiza el contexto en memoria.
 */
export function getTranslations(configTranslations = {}) {
    runtimeTranslations = { ...DEFAULT_TRANSLATIONS, ...configTranslations };
    return runtimeTranslations;
}
