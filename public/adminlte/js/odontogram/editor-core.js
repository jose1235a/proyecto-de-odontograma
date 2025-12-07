import { OdontogramEditorState } from './editor-state.js';
import { OdontogramEditorRenderer } from './editor-renderer.js';
import { buildOdontogramLayout } from './odontogram-layout.js';
import { ODONTOGRAM_CONFIG } from './odontogram-config.js';
import { getTranslation, getTranslations } from './translations.js';

export function initOdontogramEditor(config) {
    config = config || {};
    const translations = getTranslations(config.translations || {});
    const messages = config.messages || {};
    const routes = config.routes || {};

    const odontogramInitialRaw = config.initialData || [];
    const treatmentsData = config.treatments || [];
    const odontogramSlug = config.slug || '';

    const COVERAGE_PARTIAL = 'partial';
    const COVERAGE_FULL = 'full';

    const actionSavedMessage = getTranslation('action_saved', 'Action saved.');
    const actionErrorMessage = getTranslation('action_save_error', 'An error occurred while saving.');

    // Initialize canvas
    const canvas = document.getElementById('odontogram-canvas');
    if (!canvas) {
        return;
    }

    // Initialize state and renderer
    const state = new OdontogramEditorState(odontogramInitialRaw);
    const layout = buildOdontogramLayout(canvas.width);
    const renderer = new OdontogramEditorRenderer(canvas, layout);

    // Initialize UI elements
    const treatmentSummaryBody = document.getElementById('treatment-summary-body');
    const selectedToothCanvas = document.getElementById('selected-tooth-canvas');
    const uiElements = {
        summaryCurrentToothEl: document.getElementById('summary-current-tooth'),
        summaryCurrentSurfaceEl: document.getElementById('summary-current-surface'),
        treatmentSummaryBody,
        summaryTotalTreatmentsEl: document.getElementById('summary-total-treatments'),
        summaryEmptyText: treatmentSummaryBody ? treatmentSummaryBody.dataset.emptyText : '',
        summaryFullLabel: treatmentSummaryBody ? treatmentSummaryBody.dataset.fullLabel : ''
    };

    const treatmentNamesMap = {};
    const treatmentColorsMap = {};
    treatmentsData.forEach(treatment => {
        treatmentNamesMap[String(treatment.id)] = treatment.name;
        treatmentColorsMap[String(treatment.id)] = treatment.color || null;
    });
    if (selectedToothCanvas) {
        selectedToothCanvas.addEventListener('click', handleSelectedCanvasClick);
        selectedToothCanvas.style.pointerEvents = 'none';
    }

    // Helper functions
    function getTreatmentFromTool(toolKey) {
        if (!toolKey || typeof toolKey !== 'string' || !toolKey.startsWith('treatment_')) {
            return null;
        }
        const treatmentId = toolKey.replace('treatment_', '');
        return treatmentsData.find(t => String(t.id) === String(treatmentId)) || null;
    }

    function getCoverageForTool(toolKey) {
        const treatment = getTreatmentFromTool(toolKey);
        if (!treatment || !treatment.coverage) {
            return COVERAGE_PARTIAL;
        }
        return String(treatment.coverage).toLowerCase();
    }

    function isFullCoverageTool(toolKey) {
        return getCoverageForTool(toolKey) === COVERAGE_FULL;
    }

    applyColorMapToState(treatmentColorsMap);

    // Initialize renderer with state
    renderer.init(state, treatmentsData, translations);
    // Event handlers and UI initialization
    function setTool(tool) {
        state.setCurrentTool(tool);
        updateTreatmentInfoPanel();
        updateCursor();
    }

    function updateTreatmentInfoPanel() {
        if (!uiElements.summaryCurrentToothEl) return;

        uiElements.summaryCurrentToothEl.textContent = state.selectedTooth ? state.selectedTooth.number : '-';
        const surfaceLabel = state.highlightedSurface && state.highlightedSurface.surface
            ? (translations.surfaceLabels[state.highlightedSurface.surface] || state.highlightedSurface.surface)
            : '-';
        uiElements.summaryCurrentSurfaceEl.textContent = surfaceLabel;
        if (uiElements.summaryCurrentTreatmentEl) {
            uiElements.summaryCurrentTreatmentEl.textContent = state.currentTool
                ? getTreatmentLabelFromKey(state.currentTool)
                : '-';
        }
    }

    function getTreatmentLabelFromKey(condition) {
        if (!condition) return '-';
        if (condition.startsWith('treatment_')) {
            const id = condition.replace('treatment_', '');
            return treatmentNamesMap[id] || `#${id}`;
        }
        return translations.legacyTreatmentLabels[condition] || condition;
    }

    function getTreatmentColorFromKey(condition) {
        if (!condition || !condition.startsWith('treatment_')) {
            return null;
        }
        const id = condition.replace('treatment_', '');
        return treatmentColorsMap[id] || null;
    }

    function applyColorMapToState(colorMap) {
        if (!colorMap || typeof colorMap !== 'object') {
            return;
        }

        state.odontogramData.forEach(item => {
            if (!item) {
                return;
            }

            if (item.condition && item.condition.startsWith('treatment_')) {
                const treatmentId = item.condition.replace('treatment_', '');
                if (colorMap[treatmentId]) {
                    item.color = colorMap[treatmentId];
                }
            }

            if (!item.surfaces) {
                return;
            }

            Object.values(item.surfaces).forEach(surfaceEntry => {
                if (!surfaceEntry || !surfaceEntry.condition || !surfaceEntry.condition.startsWith('treatment_')) {
                    return;
                }
                const treatmentId = surfaceEntry.condition.replace('treatment_', '');
                if (colorMap[treatmentId]) {
                    surfaceEntry.color = colorMap[treatmentId];
                }
            });
        });
    }

    function applyUpdatedColorsToState(colorEntries) {
        if (!Array.isArray(colorEntries) || !colorEntries.length) {
            return;
        }

        const updatedColors = {};
        colorEntries.forEach(entry => {
            if (!entry || typeof entry.id === 'undefined' || !entry.color) {
                return;
            }
            updatedColors[String(entry.id)] = entry.color;
            treatmentColorsMap[String(entry.id)] = entry.color;
        });

        applyColorMapToState(updatedColors);
    }

    function updateCursor() {
        if (!state.currentTool || state.currentTool === '') {
            canvas.style.cursor = 'default';
            return;
        }
        if (state.currentTool.startsWith('treatment_')) {
            canvas.style.cursor = 'crosshair';
            return;
        }
        if (state.currentTool === 'clear') {
            canvas.style.cursor = 'not-allowed';
            return;
        }
        canvas.style.cursor = 'default';
    }

    function renderTreatmentList() {
        if (!uiElements.treatmentSummaryBody) return;

        const rows = [];
        state.odontogramData.forEach(item => {
            const toothNumber = item.tooth_number;
            if (isFullCoverageEntry(item)) {
                rows.push({
                    tooth: toothNumber,
                    surfaceLabel: uiElements.summaryFullLabel || translations.surfaceWholeTooth || 'Full tooth',
                    surfaceKey: null,
                    label: getTreatmentLabelFromKey(item.condition),
                });
                return;
            }

            if (item.condition && item.condition !== 'healthy') {
                rows.push({
                    tooth: toothNumber,
                    surfaceLabel: uiElements.summaryFullLabel || 'Completo',
                    surfaceKey: null,
                    label: getTreatmentLabelFromKey(item.condition),
                });
            }
            Object.entries(item.surfaces || {}).forEach(([surfaceKey, entry]) => {
                if (entry && entry.condition && entry.condition !== 'healthy') {
                    rows.push({
                        tooth: toothNumber,
                        surfaceLabel: translations.surfaceLabels[surfaceKey] || surfaceKey,
                        surfaceKey,
                        label: getTreatmentLabelFromKey(entry.condition),
                    });
                }
            });
        });

        if (uiElements.summaryTotalTreatmentsEl) {
            uiElements.summaryTotalTreatmentsEl.textContent = rows.length;
        }

        if (!rows.length) {
            uiElements.treatmentSummaryBody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">${uiElements.summaryEmptyText}</td></tr>`;
            return;
        }

        uiElements.treatmentSummaryBody.innerHTML = rows.map(row => `
            <tr>
                <td>${row.tooth}</td>
                <td>${row.surfaceLabel}</td>
                <td>${row.label}</td>
                <td class="text-right">
                    <button type="button" class="btn btn-xs btn-danger" onclick="removeTreatmentEntry(${row.tooth}, ${row.surfaceKey ? `'${row.surfaceKey}'` : 'null'})">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function removeTreatmentEntry(toothNumber, surfaceKey = null) {
        state.removeTreatment(toothNumber, surfaceKey);
        renderer.drawOdontogram();
        renderTreatmentList();
        updateTreatmentInfoPanel();
        updateFormData();
        if (state.selectedTooth) {
            renderer.drawSelectedTooth(state.selectedTooth);
        }
    }

    function updateFormData() {
        let hiddenInput = document.getElementById('odontogram-data');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'odontogram_data';
            hiddenInput.id = 'odontogram-data';
            document.getElementById('odontogram-form').appendChild(hiddenInput);
        }
        hiddenInput.value = JSON.stringify(state.odontogramData);
    }

    function saveCurrentAction() {
        const odontogramId = config.odontogramId || null;
        if (!odontogramId) return;

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('_method', 'PUT');
        formData.append('patient_id', document.getElementById('odontogram-form').patient_id.value);
        formData.append('doctor_id', document.getElementById('doctor_id').value);
        formData.append('description', document.getElementById('description').value || '');
        formData.append('odontogram_data', JSON.stringify(state.odontogramData));
        formData.append('is_active', '1');

        const updateUrl = (routes.updateOdontogram || '').replace(':slug', odontogramSlug);

        fetch(updateUrl, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
            .then(response => {
                if (response.redirected) {
                    showSuccessAndReload();
                    return;
                }
                if (response.ok) {
                    return response.json().then(() => showSuccessAndReload());
                } else if (response.status === 422) {
                    return response.json().then(data => {
                        const errors = data.errors || {};
                        const errorMessages = Object.values(errors).flat().map(msg => msg.replace(/\.$/, '')).join(' y ');
                        if (window.Swal) {
                            Swal.fire({ icon: 'error', title: 'Denegado', text: errorMessages });
                        } else if (typeof toastr !== 'undefined') {
                            toastr.error(errorMessages);
                        } else {
                            alert('Denegado: ' + errorMessages);
                        }
                    });
                } else {
                    throw new Error('Server responded with error');
                }
            })
            .catch(error => {
                if (window.Swal) {
                    Swal.fire({ icon: 'error', title: messages.errorTitle || 'Error', text: actionErrorMessage });
                } else if (typeof toastr !== 'undefined') {
                    toastr.error(actionErrorMessage);
                } else {
                    alert(actionErrorMessage);
                }
            });
    }

    function showSuccessAndReload() {
        const reloadPage = () => window.location.reload();
        if (window.Swal) {
            Swal.fire({
                icon: 'success',
                title: messages.successTitle || 'Success',
                text: actionSavedMessage,
                showConfirmButton: false,
                timer: 1400,
                timerProgressBar: true,
            }).then(reloadPage);
            return;
        }
        if (typeof toastr !== 'undefined') {
            toastr.success(actionSavedMessage);
            reloadPage();
            return;
        }
        alert(actionSavedMessage);
        reloadPage();
    }

    function isFullCoverageEntry(item) {
        if (!item.condition) {
            return false;
        }
        const surfaces = item.surfaces || {};
        return ODONTOGRAM_CONFIG.SURFACE_KEYS.every(
            key => surfaces[key] && surfaces[key].condition === item.condition
        );
    }

    function getCanvasCoordinates(event) {
        const rect = canvas.getBoundingClientRect();
        const x = (event.clientX - rect.left - renderer.offsetX) / renderer.scale;
        const y = (event.clientY - rect.top - renderer.offsetY) / renderer.scale;
        return { x, y };
    }

    function findToothAtPosition(x, y) {
        const half = ODONTOGRAM_CONFIG.TOOTH_SIZE / 2;
        return layout.teeth.find(tooth => {
            const withinX = x >= (tooth.x - half) && x <= (tooth.x + half);
            const withinY = y >= (tooth.y - half) && y <= (tooth.y + half);
            return withinX && withinY;
        });
    }

    function determineSurface(tooth, x, y) {
        const relX = x - tooth.x;
        const relY = y - tooth.y;
        return resolveSurfaceFromRelative(relX, relY, 1);
    }

    function resolveSurfaceFromRelative(relX, relY, scale = 1) {
        const innerHalf = (ODONTOGRAM_CONFIG.TOOTH_INNER_SIZE * scale) / 2;
        if (Math.abs(relX) <= innerHalf && Math.abs(relY) <= innerHalf) {
            return 'center';
        }
        if (Math.abs(relX) > Math.abs(relY)) {
            return relX < 0 ? 'left' : 'right';
        }
        return relY < 0 ? 'top' : 'bottom';
    }

    function resolveCanvasHit(event) {
        const { x, y } = getCanvasCoordinates(event);
        const tooth = findToothAtPosition(x, y);
        if (!tooth) {
            return null;
        }
        const surface = determineSurface(tooth, x, y);
        return { tooth, surface };
    }

    function applyCurrentTool(hit) {
        if (!hit) {
            return;
        }

        const { tooth, surface } = hit;
        state.setSelectedTooth(tooth);
        if (selectedToothCanvas) {
            selectedToothCanvas.style.pointerEvents = 'auto';
        }

        const existing = state.odontogramData.find(item => item.tooth_number === tooth.number) || {};

        if (!state.currentTool || state.currentTool === '') {
            renderer.drawSelectedTooth(state.selectedTooth);
            updateTreatmentInfoPanel();
            return;
        }

        if (state.currentTool === 'clear') {
            const shouldClearTooth = !surface || (existing.condition && existing.condition !== 'healthy');
            state.removeTreatment(tooth.number, shouldClearTooth ? null : surface);
        } else if (isFullCoverageTool(state.currentTool) || !surface) {
            const treatmentColor = getTreatmentColorFromKey(state.currentTool);
            const fullSurfaces = {};
            ODONTOGRAM_CONFIG.SURFACE_KEYS.forEach(key => {
                fullSurfaces[key] = {
                    condition: state.currentTool,
                    ...(treatmentColor ? { color: treatmentColor } : {}),
                };
            });
            state.updateToothData(tooth.number, {
                tooth_number: tooth.number,
                condition: state.currentTool,
                color: treatmentColor || null,
                surfaces: fullSurfaces,
            });
        } else {
            const surfaces = { ...(existing.surfaces || {}) };
            const treatmentColor = getTreatmentColorFromKey(state.currentTool);
            surfaces[surface] = {
                ...(surfaces[surface] || {}),
                condition: state.currentTool,
                ...(treatmentColor ? { color: treatmentColor } : {}),
            };

            state.updateToothData(tooth.number, {
                tooth_number: tooth.number,
                condition: existing.condition || 'healthy',
                color: null,
                surfaces,
            });
        }

        renderer.drawOdontogram();
        renderTreatmentList();
        updateFormData();
        renderer.drawSelectedTooth(state.selectedTooth);
        updateTreatmentInfoPanel();
    }

    function handleCanvasClick(event) {
        const hit = resolveCanvasHit(event);
        if (!hit) {
            clearSelectedTooth();
            return;
        }
        applyCurrentTool(hit);
    }

    function handleCanvasMove(event) {
        const hit = resolveCanvasHit(event);
        if (hit) {
            state.setHighlightedSurface({ surface: hit.surface });
        } else {
            state.setHighlightedSurface(null);
        }
        updateTreatmentInfoPanel();
    }

    function handleSelectedCanvasClick(event) {
        if (!state.selectedTooth) {
            return;
        }
        const rect = selectedToothCanvas.getBoundingClientRect();
        const relX = event.clientX - rect.left - selectedToothCanvas.width / 2;
        const relY = event.clientY - rect.top - selectedToothCanvas.height / 2;
        const previewScale = Math.min(selectedToothCanvas.width, selectedToothCanvas.height) * 0.7 / ODONTOGRAM_CONFIG.TOOTH_SIZE;
        const surface = resolveSurfaceFromRelative(relX, relY, previewScale);
        applySurfaceSelection(surface);
    }

    function applySurfaceSelection(surfaceKey) {
        if (!state.selectedTooth) {
            return;
        }
        state.setHighlightedSurface({ surface: surfaceKey });
        renderer.drawSelectedTooth(state.selectedTooth);
        updateTreatmentInfoPanel();
        if (state.currentTool) {
            applyCurrentTool({ tooth: state.selectedTooth, surface: surfaceKey });
        }
    }

    function clearSelectedTooth() {
        if (!state.selectedTooth) {
            return;
        }
        state.removeTreatment(state.selectedTooth.number, null);
        renderer.drawOdontogram();
        renderer.drawSelectedTooth(state.selectedTooth);
        updateFormData();
        updateTreatmentInfoPanel();
        state.setHighlightedSurface(null);
    }

    function showAdvancedOptions() {
        if (window.$) {
            $('#advanced-options-modal').modal('show');
            return;
        }
        const modal = document.getElementById('advanced-options-modal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'block';
        }
    }

    function saveTreatmentColors() {
        if (!routes.updateColors) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const colors = [];
        document.querySelectorAll('.treatment-color-picker').forEach(input => {
            const treatmentId = input.dataset.treatmentId;
            if (treatmentId) {
                colors.push({
                    id: Number(treatmentId),
                    color: input.value,
                });
            }
        });

        fetch(routes.updateColors, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ colors }),
        })
            .then(response => response.json())
            .then(data => {
                if (data?.success) {
                    if (window.$) {
                        $('#advanced-options-modal').modal('hide');
                    }
                    applyUpdatedColorsToState(colors);
                    renderer.drawOdontogram();
                    if (state.selectedTooth) {
                        renderer.drawSelectedTooth(state.selectedTooth);
                    }
                    updateFormData();
                    if (window.toastr) {
                        toastr.success(data.message || messages.successTitle || 'Success');
                    } else if (window.Swal) {
                        Swal.fire({
                            icon: 'success',
                            title: messages.successTitle || 'Success',
                            text: data.message || '',
                        });
                    }
                    return;
                }
                throw new Error('REQUEST_FAILED');
            })
            .catch(() => {
                if (window.toastr) {
                    toastr.error(messages.errorOccurred || 'Error');
                } else if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: messages.errorTitle || 'Error',
                        text: messages.errorOccurred || 'Error',
                    });
                }
            });
    }

    // Initialize
    renderer.init(state, treatmentsData, translations);
    renderer.drawOdontogram();
    updateTreatmentInfoPanel();
    setTool('');
    renderTreatmentList();
    updateFormData();

    canvas.addEventListener('click', handleCanvasClick);
    canvas.addEventListener('mousemove', handleCanvasMove);

    document.getElementById('odontogram-form').addEventListener('submit', updateFormData);

    // Expose functions for inline handlers
    window.setTool = setTool;
    window.saveCurrentAction = saveCurrentAction;
    window.removeTreatmentEntry = removeTreatmentEntry;
    window.clearSelectedTooth = clearSelectedTooth;
    window.showAdvancedOptions = showAdvancedOptions;
    window.saveTreatmentColors = saveTreatmentColors;
    window.loadOdontogramData = (payload) => {
        state.loadData(payload);
        state.setSelectedTooth(null);
        state.setHighlightedSurface(null);
        applyColorMapToState(treatmentColorsMap);
        if (selectedToothCanvas) {
            selectedToothCanvas.style.pointerEvents = 'none';
        }
        renderer.drawOdontogram();
        renderTreatmentList();
        updateTreatmentInfoPanel();
        updateFormData();
        if (state.selectedTooth) {
            renderer.drawSelectedTooth(state.selectedTooth);
        }
    };
}
