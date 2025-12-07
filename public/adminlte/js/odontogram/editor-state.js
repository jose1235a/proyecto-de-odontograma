// Estado y gestión de datos del editor de odontograma
export class OdontogramEditorState {
    constructor(initialData = []) {
        this.odontogramData = this.normalizeInitialData(initialData);
        this.selectedTooth = null;
        this.highlightedSurface = null;
        this.currentTool = null;
    }

    normalizeInitialData(data) {
        if (!Array.isArray(data)) return [];

        return data.map(item => {
            if (!item || !item.surfaces) return item;

            const normalized = { ...item };
            if (item.surfaces && typeof item.surfaces === 'object') {
                const normalizedSurfaces = {};
                Object.entries(item.surfaces).forEach(([key, value]) => {
                    const normalizedKey = this.legacySurfaceMap[key] || key;
                    if (this.validSurfaces.includes(normalizedKey)) {
                        normalizedSurfaces[normalizedKey] = value;
                    }
                });
                normalized.surfaces = normalizedSurfaces;
            }
            return normalized;
        });
    }

    get legacySurfaceMap() {
        return {
            mesiobuccal: 'left',
            distobuccal: 'right',
            mesiolingual: 'left',
            distolingual: 'right',
            occlusal: 'center',
            incisal: 'center',
        };
    }

    get validSurfaces() {
        return ['top', 'right', 'bottom', 'left', 'center'];
    }

    getCurrentData() {
        return this.odontogramData;
    }

    updateToothData(toothNumber, data) {
        const index = this.odontogramData.findIndex(t => t.tooth_number === toothNumber);
        if (index >= 0) {
            this.odontogramData[index] = { ...this.odontogramData[index], ...data };
        } else {
            this.odontogramData.push({ tooth_number: toothNumber, ...data });
        }
    }

    reset() {
        this.odontogramData = [];
        this.selectedTooth = null;
        this.highlightedSurface = null;
        this.currentTool = null;
    }

    setSelectedTooth(tooth) {
        this.selectedTooth = tooth;
    }

    setHighlightedSurface(surface) {
        this.highlightedSurface = surface;
    }

    setCurrentTool(tool) {
        this.currentTool = tool;
    }

    loadData(data) {
        this.odontogramData = this.normalizeInitialData(data);
    }

    removeTreatment(toothNumber, surfaceKey = null) {
        const index = this.odontogramData.findIndex(t => t.tooth_number === toothNumber);
        if (index === -1) return;

        const toothData = this.odontogramData[index];

        if (!surfaceKey) {
            toothData.condition = 'healthy';
            toothData.color = null;
            toothData.surfaces = {};
            this.odontogramData.splice(index, 1);
        } else {
            if (toothData.surfaces && toothData.surfaces[surfaceKey]) {
                delete toothData.surfaces[surfaceKey].condition;
                if (!toothData.surfaces[surfaceKey].color && !toothData.surfaces[surfaceKey].symbol) {
                    delete toothData.surfaces[surfaceKey];
                }
            }
            if ((!toothData.surfaces || !Object.keys(toothData.surfaces).length) &&
                (!toothData.condition || toothData.condition === 'healthy')) {
                this.odontogramData.splice(index, 1);
            }
        }
    }
}
