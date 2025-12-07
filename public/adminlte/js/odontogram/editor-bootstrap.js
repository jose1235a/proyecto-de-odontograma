import { initOdontogramEditor } from './editor-core.js';

window.initOdontogramEditor = initOdontogramEditor;

function bootstrapEditor() {
    const config = window.odontogramEditorConfig;
    const canvas = document.getElementById('odontogram-canvas');

    if (!config || !canvas) {
        return;
    }

    initOdontogramEditor(config);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootstrapEditor);
} else {
    bootstrapEditor();
}
