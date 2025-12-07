import { ODONTOGRAM_CONFIG } from './odontogram-config.js';

// Funciones de renderizado del editor de odontograma
export class OdontogramEditorRenderer {
    constructor(canvas, layout) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.layout = layout;
        this.teeth = layout.teeth;
        this.separators = layout.separators;
        this.scale = 1;
        this.offsetX = 0;
        this.offsetY = 0;
        this.state = null;
        this.treatmentsData = [];
        this.translations = {};
    }

    init(state, treatmentsData, translations) {
        this.state = state;
        this.treatmentsData = treatmentsData;
        this.translations = translations;
    }

    drawOdontogram() {
        if (!this.state) {
            return;
        }

        this.ctx.save();
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        this.ctx.translate(this.offsetX, this.offsetY);
        this.ctx.scale(this.scale, this.scale);

        this.drawGrid();
        this.drawTeeth();
        this.drawSeparators();

        this.ctx.restore();
    }

    drawGrid() {
        this.ctx.save();
        this.ctx.strokeStyle = ODONTOGRAM_CONFIG.GRID_COLOR;
        this.ctx.lineWidth = 1;
        this.separators.forEach(y => {
            this.ctx.beginPath();
            this.ctx.moveTo(70, y);
            this.ctx.lineTo(this.canvas.width - 70, y);
            this.ctx.stroke();
        });
        this.ctx.restore();
    }

    drawTeeth() {
        this.teeth.forEach(tooth => {
            const toothData = this.state.odontogramData.find(t => t.tooth_number === tooth.number) || {};

            this.ctx.save();
            this.ctx.translate(tooth.x, tooth.y);
            this.drawToothBase(toothData.condition || 'healthy', toothData.color);
            this.ctx.restore();

            this.drawToothLabel(tooth);
            this.drawConditionIndicator(tooth, toothData);
            this.drawNotesBadge(tooth, toothData);
            this.drawSurfaces(tooth, toothData);
        });
    }

    drawToothBase(condition, overrideColor = null) {
        const size = ODONTOGRAM_CONFIG.TOOTH_SIZE;
        const innerSize = ODONTOGRAM_CONFIG.TOOTH_INNER_SIZE;
        const outerHalf = size / 2;
        const innerHalf = innerSize / 2;

        this.ctx.save();
        this.ctx.lineJoin = 'round';
        this.ctx.fillStyle = overrideColor || this.getToothColor(condition);
        this.ctx.fillRect(-outerHalf, -outerHalf, size, size);
        this.ctx.strokeStyle = ODONTOGRAM_CONFIG.TOOTH_BORDER_COLOR;
        this.ctx.lineWidth = 1.4;
        this.ctx.strokeRect(-outerHalf, -outerHalf, size, size);

        this.ctx.fillStyle = '#ffffff';
        this.ctx.fillRect(-innerHalf, -innerHalf, innerSize, innerSize);
        this.ctx.strokeRect(-innerHalf, -innerHalf, innerSize, innerSize);

        this.ctx.beginPath();
        this.ctx.moveTo(-outerHalf, -outerHalf);
        this.ctx.lineTo(-innerHalf, -innerHalf);
        this.ctx.moveTo(outerHalf, -outerHalf);
        this.ctx.lineTo(innerHalf, -innerHalf);
        this.ctx.moveTo(-outerHalf, outerHalf);
        this.ctx.lineTo(-innerHalf, innerHalf);
        this.ctx.moveTo(outerHalf, outerHalf);
        this.ctx.lineTo(innerHalf, innerHalf);
        this.ctx.strokeStyle = ODONTOGRAM_CONFIG.TOOTH_BORDER_COLOR;
        this.ctx.stroke();

        this.ctx.restore();
    }

    drawToothLabel(tooth) {
        this.ctx.save();
        this.ctx.translate(tooth.x, tooth.y);
        this.ctx.fillStyle = ODONTOGRAM_CONFIG.TOOTH_LABEL_COLOR;
        this.ctx.font = '600 13px "Source Sans Pro", Arial';
        this.ctx.textAlign = 'center';
        this.ctx.textBaseline = tooth.labelPosition === 'above' ? 'bottom' : 'top';
        const offset = tooth.labelPosition === 'above' ? -(ODONTOGRAM_CONFIG.TOOTH_SIZE / 2) - 16 : ODONTOGRAM_CONFIG.TOOTH_SIZE / 2 + 10;
        this.ctx.fillText(String(tooth.number), 0, offset);
        this.ctx.restore();
    }

    drawConditionIndicator(tooth, toothData) {
        if (!toothData.condition || toothData.condition === 'healthy') return;
        this.ctx.save();
        this.ctx.translate(tooth.x, tooth.y);
        this.ctx.fillStyle = this.getConditionIndicatorColor(toothData.condition);
        this.ctx.beginPath();
        this.ctx.arc(12, -14, 5, 0, 2 * Math.PI);
        this.ctx.fill();
        this.ctx.restore();
    }

    drawNotesBadge(tooth, toothData) {
        if (!toothData.notes) return;

        this.ctx.save();
        this.ctx.translate(tooth.x, tooth.y);
        this.ctx.fillStyle = '#007bff';
        this.ctx.font = '12px Arial';
        this.ctx.textBaseline = 'alphabetic';
        this.ctx.fillText('N', -16, -ODONTOGRAM_CONFIG.TOOTH_SIZE / 2 - 6);
        this.ctx.restore();
    }

    drawSurfaces(tooth, toothData) {
        if (!toothData.surfaces) return;

        this.ctx.save();
        this.ctx.translate(tooth.x, tooth.y);
        this.drawSurfacesForContext(this.ctx, toothData);
        this.ctx.restore();
    }

    drawSelectedTooth(tooth) {
        if (!tooth) return;

        const toothData = this.state.odontogramData.find(t => t.tooth_number === tooth.number) || {};
        const selectedCanvas = document.getElementById('selected-tooth-canvas');
        if (!selectedCanvas) return;

        const ctx = selectedCanvas.getContext('2d');
        ctx.clearRect(0, 0, selectedCanvas.width, selectedCanvas.height);

        const previewScale = Math.min(selectedCanvas.width, selectedCanvas.height) * 0.7 / ODONTOGRAM_CONFIG.TOOTH_SIZE;
        ctx.save();
        ctx.translate(selectedCanvas.width / 2, selectedCanvas.height / 2);
        this.drawToothBaseForContext(ctx, toothData.condition || 'healthy', previewScale, toothData.color);
        this.drawSurfacesForContext(ctx, toothData, previewScale);
        ctx.restore();
    }

    drawToothBaseForContext(ctx, condition, scale = 1, overrideColor = null) {
        const size = ODONTOGRAM_CONFIG.TOOTH_SIZE * scale;
        const innerSize = ODONTOGRAM_CONFIG.TOOTH_INNER_SIZE * scale;
        const outerHalf = size / 2;
        const innerHalf = innerSize / 2;

        ctx.save();
        ctx.lineJoin = 'round';
        ctx.fillStyle = overrideColor || this.getToothColor(condition);
        ctx.fillRect(-outerHalf, -outerHalf, size, size);
        ctx.strokeStyle = ODONTOGRAM_CONFIG.TOOTH_BORDER_COLOR;
        ctx.lineWidth = 1.4;
        ctx.strokeRect(-outerHalf, -outerHalf, size, size);

        ctx.fillStyle = '#ffffff';
        ctx.fillRect(-innerHalf, -innerHalf, innerSize, innerSize);
        ctx.strokeRect(-innerHalf, -innerHalf, innerSize, innerSize);

        ctx.beginPath();
        ctx.moveTo(-outerHalf, -outerHalf);
        ctx.lineTo(-innerHalf, -innerHalf);
        ctx.moveTo(outerHalf, -outerHalf);
        ctx.lineTo(innerHalf, -innerHalf);
        ctx.moveTo(-outerHalf, outerHalf);
        ctx.lineTo(-innerHalf, innerHalf);
        ctx.moveTo(outerHalf, outerHalf);
        ctx.lineTo(innerHalf, innerHalf);
        ctx.strokeStyle = ODONTOGRAM_CONFIG.TOOTH_BORDER_COLOR;
        ctx.stroke();

        ctx.restore();
    }

    drawSurfacesForContext(ctx, toothData, scale = 1) {
        if (!toothData.surfaces) return;

        const surfaces = ODONTOGRAM_CONFIG.SURFACE_KEYS;
        const polygons = this.getSurfacePolygons(scale);

        surfaces.forEach(surface => {
            const entry = toothData.surfaces[surface];
            const polygon = polygons[surface];
            if (!polygon || !entry) return;

            const fill = this.getSurfaceFillColor(entry);
            if (fill) {
                this.drawSurfacePolygonWithContext(ctx, polygon, fill);
            }

            if (surface === 'center' && entry.symbol && entry.symbol !== 'none') {
                this.drawSurfaceSymbolWithContext(ctx, polygon, entry.symbol);
            }
        });
    }

    drawSeparators() {
        // Separators are drawn in drawGrid
    }

    getSurfacePolygons(scaleFactor = 1) {
        const outerHalf = (ODONTOGRAM_CONFIG.TOOTH_SIZE * scaleFactor) / 2;
        const innerHalf = (ODONTOGRAM_CONFIG.TOOTH_INNER_SIZE * scaleFactor) / 2;

        return {
            top: [
                { x: -outerHalf, y: -outerHalf },
                { x: outerHalf, y: -outerHalf },
                { x: innerHalf, y: -innerHalf },
                { x: -innerHalf, y: -innerHalf },
            ],
            bottom: [
                { x: -innerHalf, y: innerHalf },
                { x: innerHalf, y: innerHalf },
                { x: outerHalf, y: outerHalf },
                { x: -outerHalf, y: outerHalf },
            ],
            left: [
                { x: -outerHalf, y: -outerHalf },
                { x: -innerHalf, y: -innerHalf },
                { x: -innerHalf, y: innerHalf },
                { x: -outerHalf, y: outerHalf },
            ],
            right: [
                { x: innerHalf, y: -innerHalf },
                { x: outerHalf, y: -outerHalf },
                { x: outerHalf, y: outerHalf },
                { x: innerHalf, y: innerHalf },
            ],
            center: [
                { x: -innerHalf, y: -innerHalf },
                { x: innerHalf, y: -innerHalf },
                { x: innerHalf, y: innerHalf },
                { x: -innerHalf, y: innerHalf },
            ],
        };
    }

    drawSurfacePolygon(polygon, fillColor = null, strokeColor = '#4a7070', lineWidth = 1) {
        this.drawSurfacePolygonWithContext(this.ctx, polygon, fillColor, strokeColor, lineWidth);
    }

    drawSurfacePolygonWithContext(ctx, polygon, fillColor = null, strokeColor = '#4a7070', lineWidth = 1) {
        ctx.save();
        ctx.beginPath();
        polygon.forEach((point, index) => {
            if (index === 0) {
                ctx.moveTo(point.x, point.y);
            } else {
                ctx.lineTo(point.x, point.y);
            }
        });
        ctx.closePath();
        if (fillColor) {
            ctx.fillStyle = fillColor;
            ctx.fill();
        }
        if (strokeColor && lineWidth !== 0) {
            ctx.strokeStyle = strokeColor;
            ctx.lineWidth = lineWidth;
            ctx.stroke();
        }
        ctx.restore();
    }

    drawSurfaceSymbol(polygon, symbolKey) {
        this.drawSurfaceSymbolWithContext(this.ctx, polygon, symbolKey);
    }

    drawSurfaceSymbolWithContext(ctx, polygon, symbolKey) {
        const bounds = polygon.reduce(
            (acc, point) => ({
                minX: Math.min(acc.minX, point.x),
                maxX: Math.max(acc.maxX, point.x),
                minY: Math.min(acc.minY, point.y),
                maxY: Math.max(acc.maxY, point.y),
            }),
            { minX: Infinity, maxX: -Infinity, minY: Infinity, maxY: -Infinity }
        );
        const centerX = (bounds.maxX + bounds.minX) / 2;
        const centerY = (bounds.maxY + bounds.minY) / 2;
        const width = (bounds.maxX - bounds.minX) * 0.7;
        const height = (bounds.maxY - bounds.minY) * 0.7;

        ctx.save();
        ctx.strokeStyle = '#1f2937';
        ctx.fillStyle = '#1f2937';
        ctx.lineWidth = 1.4;

        switch (symbolKey) {
            case 'cross':
                ctx.beginPath();
                ctx.moveTo(centerX - width / 2, centerY - height / 2);
                ctx.lineTo(centerX + width / 2, centerY + height / 2);
                ctx.moveTo(centerX + width / 2, centerY - height / 2);
                ctx.lineTo(centerX - width / 2, centerY + height / 2);
                ctx.stroke();
                break;
            case 'triangle':
                ctx.beginPath();
                ctx.moveTo(centerX, centerY - height / 2);
                ctx.lineTo(centerX + width / 2, centerY + height / 2);
                ctx.lineTo(centerX - width / 2, centerY + height / 2);
                ctx.closePath();
                ctx.fill();
                break;
            case 'dot':
                ctx.beginPath();
                ctx.arc(centerX, centerY, Math.min(width, height) / 4, 0, Math.PI * 2);
                ctx.fill();
                break;
            case 'ring':
                ctx.beginPath();
                ctx.lineWidth = 1.2;
                ctx.arc(centerX, centerY, Math.min(width, height) / 3, 0, Math.PI * 2);
                ctx.stroke();
                break;
            case 'bar':
                ctx.fillRect(centerX - width / 6, centerY - height / 2, width / 3, height);
                break;
        }

        ctx.restore();
    }

    getSurfaceFillColor(entry) {
        if (entry?.color) {
            return ODONTOGRAM_CONFIG.SURFACE_COLORS[entry.color] || entry.color;
        }
        if (entry?.condition && entry.condition !== 'healthy') {
            return this.getSurfaceColor(entry.condition);
        }
        return null;
    }

    getToothColor(condition) {
        if (condition && condition.startsWith('treatment_')) {
            const treatmentId = condition.replace('treatment_', '');
            const colors = ODONTOGRAM_CONFIG.TREATMENT_COLORS;
            const hash = treatmentId.split('').reduce((acc, char) => {
                acc = ((acc << 5) - acc) + char.charCodeAt(0);
                return acc & acc;
            }, 0);
            return colors[Math.abs(hash) % colors.length];
        }

        return ODONTOGRAM_CONFIG.CONDITION_COLORS[condition] || ODONTOGRAM_CONFIG.CONDITION_COLORS.healthy;
    }

    getConditionIndicatorColor(condition) {
        if (condition && condition.startsWith('treatment_')) {
            const treatmentId = condition.replace('treatment_', '');
            const colors = ODONTOGRAM_CONFIG.INDICATOR_COLORS;
            const hash = treatmentId.split('').reduce((acc, char) => {
                acc = ((acc << 5) - acc) + char.charCodeAt(0);
                return acc & acc;
            }, 0);
            return colors[Math.abs(hash) % colors.length];
        }

        return ODONTOGRAM_CONFIG.INDICATOR_COLOR_MAP[condition] || ODONTOGRAM_CONFIG.INDICATOR_COLOR_MAP.default;
    }

    getSurfaceColor(condition) {
        return this.getConditionIndicatorColor(condition);
    }

    setZoom(scale, offsetX, offsetY) {
        this.scale = Math.max(0.5, Math.min(3, scale));
        this.offsetX = offsetX;
        this.offsetY = offsetY;
    }
}
