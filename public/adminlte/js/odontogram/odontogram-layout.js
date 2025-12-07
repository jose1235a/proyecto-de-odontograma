export const ODONTOGRAM_ROW_CONFIG = [
    {
        labelPosition: 'above',
        groups: [
            { align: 'center-left', numbers: [18, 17, 16, 15, 14, 13, 12, 11], centerGap: 36 },
            { align: 'center-right', numbers: [21, 22, 23, 24, 25, 26, 27, 28], centerGap: 36 },
        ],
    },
    {
        labelPosition: 'below',
        groups: [
            { align: 'center-left', numbers: [55, 54, 53, 52, 51], centerGap: 36 },
            { align: 'center-right', numbers: [61, 62, 63, 64, 65], centerGap: 36 },
        ],
    },
    {
        labelPosition: 'below',
        groups: [
            { align: 'center-left', numbers: [85, 84, 83, 82, 81], centerGap: 36 },
            { align: 'center-right', numbers: [71, 72, 73, 74, 75], centerGap: 36 },
        ],
    },
    {
        labelPosition: 'below',
        groups: [
            { align: 'center-left', numbers: [48, 47, 46, 45, 44, 43, 42, 41], centerGap: 36 },
            { align: 'center-right', numbers: [31, 32, 33, 34, 35, 36, 37, 38], centerGap: 36 },
        ],
    },
];

export const ODONTOGRAM_LAYOUT_SETTINGS = {
    baseY: 80,
    rowGap: 90,
    leftOffset: 110,
    toothSpacing: 45,
    centerGap: 20,
};

export function buildOdontogramLayout(canvasWidth) {
    const teeth = [];
    const rowCenters = [];
    const centerX = canvasWidth / 2;

    ODONTOGRAM_ROW_CONFIG.forEach((row, rowIndex) => {
        const y = ODONTOGRAM_LAYOUT_SETTINGS.baseY + rowIndex * ODONTOGRAM_LAYOUT_SETTINGS.rowGap;
        rowCenters.push(y);

        row.groups.forEach(group => {
            const spacing = group.spacing || ODONTOGRAM_LAYOUT_SETTINGS.toothSpacing;
            const blockWidth = (group.numbers.length - 1) * spacing;
            let startX;

            if (typeof group.startX === 'number') {
                startX = group.startX;
            } else if (group.align === 'left') {
                startX = ODONTOGRAM_LAYOUT_SETTINGS.leftOffset;
            } else if (group.align === 'right') {
                startX = canvasWidth - ODONTOGRAM_LAYOUT_SETTINGS.leftOffset - blockWidth;
            } else if (group.align === 'center-left') {
                const gap = typeof group.centerGap === 'number' ? group.centerGap : ODONTOGRAM_LAYOUT_SETTINGS.centerGap;
                startX = centerX - gap - blockWidth;
            } else if (group.align === 'center-right') {
                const gap = typeof group.centerGap === 'number' ? group.centerGap : ODONTOGRAM_LAYOUT_SETTINGS.centerGap;
                startX = centerX + gap;
            } else {
                startX = (canvasWidth - blockWidth) / 2;
            }

            if (typeof group.offsetX === 'number') {
                startX += group.offsetX;
            }

            group.numbers.forEach((number, index) => {
                teeth.push({
                    number,
                    x: startX + index * spacing,
                    y,
                    labelPosition: row.labelPosition || 'below',
                });
            });
        });
    });

    const separators = [];
    for (let i = 0; i < rowCenters.length - 1; i++) {
        separators.push((rowCenters[i] + rowCenters[i + 1]) / 2);
    }

    return { teeth, separators };
}
