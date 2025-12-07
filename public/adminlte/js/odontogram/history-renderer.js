import { getTranslation } from './translations.js';

const defaultTranslations = {
    noRecords: getTranslation('no_records', 'No records'),
    doctorNotSpecified: getTranslation('doctor_not_specified', '-'),
    toothLabel: getTranslation('tooth_label', 'Tooth'),
    fullSurfaceLabel: getTranslation('surface_whole_tooth', 'Whole tooth'),
    actionLabels: {},
    surfaceLabels: {},
};

function formatDateTime(value) {
    if (!value) {
        return '-';
    }
    const date = value instanceof Date ? value : new Date(value);
    if (Number.isNaN(date.getTime())) {
        return '-';
    }
    const datePart = date.toLocaleDateString();
    const timePart = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    return `${datePart} ${timePart}`;
}

function getSurfaceLabel(surfaceKey, translations) {
    if (!surfaceKey) {
        return '';
    }
    return translations.surfaceLabels[surfaceKey] || surfaceKey;
}

function renderTreatmentItem(item, translations) {
    const surfaceLabel = item.surface
        ? getSurfaceLabel(item.surface, translations)
        : `(${translations.fullSurfaceLabel})`;
    const actionLabel = translations.actionLabels[item.action] || item.action;
    const doctorName = item.doctor
        ? `${item.doctor.name ?? ''} ${item.doctor.last_name ?? ''}`.trim()
        : translations.doctorNotSpecified;
    const treatmentDate = item.treatment_date
        ? new Date(item.treatment_date).toLocaleDateString()
        : '';

    return `
        <div class="treatment-history-item">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong>${translations.toothLabel} ${item.tooth_number}</strong>
                    ${surfaceLabel ? ` - ${surfaceLabel}` : ''}
                </div>
                <small class="text-muted">${treatmentDate}</small>
            </div>
            <div class="mt-1">
                <span class="badge badge-${item.action === 'applied' ? 'success' : 'warning'}">${actionLabel}</span>
                ${item.treatment_type ? `<span class="badge badge-info">${item.treatment_type}</span>` : ''}
            </div>
            <div class="mt-1">
                <small class="text-primary">
                    <i class="fas fa-user-md"></i>
                    ${doctorName}
                </small>
            </div>
        </div>
    `;
}

function renderSummaryItem(item, translations) {
    const doctorName = item.doctor
        ? `${item.doctor.name ?? ''} ${item.doctor.last_name ?? ''}`.trim()
        : translations.doctorNotSpecified;

    return `
        <div class="treatment-history-item">
            <div class="d-flex justify-content-between align-items-start">
                <strong>${item.registered_at || '-'}</strong>
                <small class="text-muted">${doctorName}</small>
            </div>
            <div class="mt-1 text-muted">${item.description || '-'}</div>
        </div>
    `;
}

function buildDescriptionContent(item, translations) {
    if (item.description) {
        return `<div>${item.description}</div>${item.notes ? `<div class="text-muted small mb-0">${item.notes}</div>` : ''}`;
    }

    if (item.notes) {
        return `<div class="text-muted small mb-0">${item.notes}</div>`;
    }

    return '-';
}

function renderTableRows(history, translations, options = {}) {
    const columnCount = options.columns || 1;
    if (!history.length) {
        return `<tr><td colspan="${columnCount}" class="text-center text-muted">${translations.noRecords}</td></tr>`;
    }

    return history
        .map((item) => {
            const doctorName = item.doctor
                ? `${item.doctor.name ?? ''} ${item.doctor.last_name ?? ''}`.trim()
                : translations.doctorNotSpecified;
            const registeredAt = formatDateTime(item.treatment_date || item.registered_at);

            return `
                <tr>
                    <td>${registeredAt}</td>
                    <td>${buildDescriptionContent(item, translations)}</td>
                    <td>${doctorName || '-'}</td>
                </tr>
            `;
        })
        .join('');
}

export function renderHistoryCards(containerId, history = [], options = {}) {
    const container = document.getElementById(containerId);
    if (!container) {
        return;
    }

    const translations = {
        ...defaultTranslations,
        ...(options.translations || {}),
    };

    const templateType = options.template || 'table';

    if (templateType === 'table') {
        container.innerHTML = renderTableRows(history, translations, options);
        return;
    }

    if (!history.length) {
        if (templateType === 'table') {
            container.innerHTML = renderTableRows(history, translations, options);
            return;
        }
        container.innerHTML = `<div class="text-center text-muted">${translations.noRecords}</div>`;
        return;
    }

    const renderTemplate = templateType === 'summary' ? renderSummaryItem : renderTreatmentItem;

    container.innerHTML = history.map((item) => renderTemplate(item, translations)).join('');
}
