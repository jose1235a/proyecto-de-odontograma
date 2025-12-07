import { renderHistoryCards } from './history-renderer.js';

window.treatmentHistoryPanels = window.treatmentHistoryPanels || [];

const processedPanels = new Set();
const panelDataCache = new Map();
const tabListeners = new Set();

function fetchTreatmentHistory(config) {
    const requestUrl = new URL(config.historyUrl, window.location.origin);

    if (config.odontogramId) {
        requestUrl.searchParams.set('odontogram_id', config.odontogramId);
    }

    if (config.patientId) {
        requestUrl.searchParams.set('patient_id', config.patientId);
    }

    return fetch(requestUrl.toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    }).then((response) => {
        if (!response.ok) {
            throw new Error('REQUEST_FAILED');
        }
        return response.json();
    });
}

function showError(config) {
    const container = document.getElementById(config.panelId);
    if (!container) {
        return;
    }
    const message = config.translations?.errorText || 'Error';
    if ((config.template || 'treatment') === 'table') {
        container.innerHTML = `<tr><td colspan="${config.columns || 1}" class="text-center text-muted">${message}</td></tr>`;
        return;
    }
    container.innerHTML = `<div class="text-center text-muted">${message}</div>`;
}

function renderPanel(config, historyData) {
    renderHistoryCards(config.panelId, historyData, {
        translations: config.translations,
        template: config.template || 'treatment',
        columns: config.columns || 1,
    });
    const badge = document.getElementById(config.badgeId);
    if (badge) {
        badge.textContent = historyData.length;
    }
}

function attachTabListener(config) {
    if (!config?.tabSelector || tabListeners.has(config.panelId)) {
        return;
    }

    const setupListener = () => {
        const tabElement = document.querySelector(config.tabSelector);
        if (!tabElement || tabElement.dataset.historyListener) {
            return;
        }

        tabElement.addEventListener('shown.bs.tab', () => {
            processPanel(config, { renderOnly: true });
        });
        tabElement.dataset.historyListener = '1';
        tabListeners.add(config.panelId);
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupListener, { once: true });
    } else {
        setupListener();
    }
}

function processPanel(config, options = {}) {
    if (!config || !config.panelId) {
        return;
    }

    const { renderOnly = false } = options;

    const executeFetch = () => {
        const container = document.getElementById(config.panelId);
        if (!container) {
            return;
        }
        processedPanels.add(config.panelId);
        fetchTreatmentHistory(config)
            .then((data) => {
                if (!data?.success) {
                    throw new Error('REQUEST_FAILED');
                }
                panelDataCache.set(config.panelId, data.data);
                renderPanel(config, data.data);
            })
            .catch(() => {
                showError(config);
            });
    };

    if (renderOnly) {
        if (panelDataCache.has(config.panelId)) {
            renderPanel(config, panelDataCache.get(config.panelId));
            return;
        }
        executeFetch();
        return;
    }

    attachTabListener(config);

    if (processedPanels.has(config.panelId)) {
        return;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', executeFetch, { once: true });
    } else {
        executeFetch();
    }
}

function initExistingPanels() {
    window.treatmentHistoryPanels.forEach((config) => {
        processPanel(config);
    });
}

function registerPanel(config) {
    if (!config) {
        return;
    }
    window.treatmentHistoryPanels.push(config);
    processPanel(config);

    if (config.tabSelector) {
        const tabElement = document.querySelector(config.tabSelector);
        if (tabElement && !tabElement.dataset.historyListener) {
            tabElement.addEventListener('shown.bs.tab', () => {
                processPanel(config, { renderOnly: true });
            });
            tabElement.dataset.historyListener = '1';
        }
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initExistingPanels);
} else {
    initExistingPanels();
}

window.registerTreatmentHistoryPanel = registerPanel;
