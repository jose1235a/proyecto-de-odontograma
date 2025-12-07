import { normalizeInitialData } from './editor-data.js';
import { buildOdontogramLayout } from './odontogram-layout.js';
import { OdontogramEditorRenderer } from './editor-renderer.js';
import { OdontogramEditorState } from './editor-state.js';

function initViewer() {
    const config = window.odontogramViewerConfig || {};
    const canvasId = config.canvasId || 'odontogram-canvas';
    const canvas = document.getElementById(canvasId);
    if (!canvas) {
        return;
    }

    const layout = buildOdontogramLayout(canvas.width);
    const renderer = new OdontogramEditorRenderer(canvas, layout);
    const state = new OdontogramEditorState(normalizeInitialData(config.initialData || []));

    renderer.init(state, config.treatments || [], config.translations || {});
    renderer.drawOdontogram();

    let scale = 1;
    let offsetX = 0;
    let offsetY = 0;

    const applyTransform = () => {
        renderer.setZoom(scale, offsetX, offsetY);
        renderer.drawOdontogram();
    };

    function attachHistoryButtons(selector) {
        document.querySelectorAll(selector).forEach((button) => {
            button.addEventListener('click', () => {
                const payload = button.dataset.history ? JSON.parse(button.dataset.history) : [];
                window.loadOdontogramData(payload);
            });
        });
    }

    function setZoomHandlers() {
        let isDragging = false;
        let lastX = 0;
        let lastY = 0;

        canvas.addEventListener('mousedown', (event) => {
            isDragging = true;
            lastX = event.clientX;
            lastY = event.clientY;
        });

        canvas.addEventListener('mousemove', (event) => {
            if (!isDragging) {
                return;
            }
            offsetX += event.clientX - lastX;
            offsetY += event.clientY - lastY;
            lastX = event.clientX;
            lastY = event.clientY;
            applyTransform();
        });

        ['mouseup', 'mouseleave'].forEach((evt) => {
            canvas.addEventListener(evt, () => {
                isDragging = false;
            });
        });

        canvas.addEventListener('wheel', (event) => {
            event.preventDefault();
            const zoomFactor = event.deltaY > 0 ? 0.9 : 1.1;
            scale = Math.max(0.5, Math.min(3, scale * zoomFactor));
            applyTransform();
        });
    }

    window.resetZoom = function () {
        scale = 1;
        offsetX = 0;
        offsetY = 0;
        applyTransform();
    };

    window.loadOdontogramData = function (payload) {
        state.loadData(normalizeInitialData(payload || []));
        renderer.drawOdontogram();
    };

    attachHistoryButtons(config.historyButtonsSelector || '.load-history');
    setZoomHandlers();
}

document.addEventListener('DOMContentLoaded', initViewer);
