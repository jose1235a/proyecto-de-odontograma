function ready(callback) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', callback, { once: true });
        return;
    }
    callback();
}

function getConfig() {
    return window.odontogramHistoryConfig || {};
}

function getTranslation(key, fallback = '') {
    const config = getConfig();
    return (config.translations && config.translations[key]) || fallback;
}

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

function attachViewHandlers() {
    document.querySelectorAll('.load-history').forEach((button) => {
        button.addEventListener('click', () => {
            const payload = button.dataset.history ? JSON.parse(button.dataset.history) : [];
            if (typeof window.loadOdontogramData === 'function') {
                window.loadOdontogramData(payload);
            }
        });
    });
}

function updateHistoryCounter() {
    const badge = document.getElementById('history-count-badge');
    if (!badge) {
        return;
    }
    const current = parseInt(badge.textContent, 10) || 0;
    badge.textContent = Math.max(current - 1, 0);
}

function removeHistoryRow(historyId) {
    const row = document.querySelector(`[data-history-row="${historyId}"]`);
    row?.remove();
}

function updateHistoryRow(data) {
    if (!data?.id) {
        return;
    }
    const row = document.querySelector(`[data-history-row="${data.id}"]`);
    if (!row) {
        return;
    }
    const descriptionCell = row.querySelector('[data-column="description"]');
    if (descriptionCell) {
        descriptionCell.textContent = data.description_short || data.description || '-';
    }
    const doctorCell = row.querySelector('[data-column="doctor"]');
    if (doctorCell) {
        doctorCell.textContent = data.doctor_name || '-';
    }

    const editButton = row.querySelector('.edit-history');
    if (editButton) {
        editButton.dataset.description = data.description || '';
        editButton.dataset.doctorId = data.doctor?.id || '';
    }
}

function requestDeletion(button, csrfToken) {
    const url = button.dataset.deleteUrl;
    const historyId = button.dataset.historyId;
    if (!url || !csrfToken) {
        Swal.fire({
            icon: 'error',
            title: getTranslation('errorTitle'),
            text: getTranslation('genericError'),
        });
        return;
    }

    Swal.fire({
        title: getTranslation('confirmTitle'),
        text: getTranslation('confirmText'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: getTranslation('confirmYes'),
        cancelButtonText: getTranslation('confirmCancel'),
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'application/json',
            },
            body: new URLSearchParams({
                _method: 'DELETE',
                _token: csrfToken,
            }),
        })
            .then((resp) => resp.json().catch(() => ({})))
            .then((data) => {
                if (data?.success) {
                    removeHistoryRow(historyId);
                    updateHistoryCounter();
                    Swal.fire({
                        icon: 'success',
                        title: getTranslation('successTitle'),
                        text: getTranslation('deletedMessage') + ' La página se recargará.',
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.reload();
                    });
                    return;
                }
                window.location.reload();
            })
            .catch(() => window.location.reload());
    });
}

function attachDeleteHandlers() {
    const csrfToken = getCsrfToken();
    document.querySelectorAll('.delete-history').forEach((button) => {
        button.addEventListener('click', () => requestDeletion(button, csrfToken));
    });
}

function hideModal(modal) {
    if (!modal) {
        return;
    }
    if (window.jQuery && typeof window.jQuery(modal).modal === 'function') {
        window.jQuery(modal).modal('hide');
        return;
    }
    modal.classList.remove('show');
    modal.style.display = 'none';
}

function showModal(modal) {
    if (!modal) {
        return;
    }
    if (window.jQuery && typeof window.jQuery(modal).modal === 'function') {
        window.jQuery(modal).modal('show');
        return;
    }
    modal.classList.add('show');
    modal.style.display = 'block';
}

function attachEditHandlers() {
    const modal = document.getElementById('editHistoryModal');
    const form = document.getElementById('edit-history-form');
    const doctorField = document.getElementById('edit-history-doctor');
    const descriptionField = document.getElementById('edit-history-description');
    if (!modal || !form || !descriptionField) {
        return;
    }

    const openModal = (button) => {
        form.dataset.updateUrl = button.dataset.updateUrl || '';
        form.dataset.historyId = button.dataset.historyId || '';
        if (doctorField) {
            doctorField.value = button.dataset.doctorId || '';
            if (window.jQuery && typeof window.jQuery.fn.select2 === 'function') {
                if (!window.jQuery(doctorField).data('select2')) {
                    window.jQuery(doctorField).select2({
                        placeholder: window.jQuery(doctorField).find('option:first').text() || 'Seleccione un doctor',
                        width: '100%'
                    });
                }
                window.jQuery(doctorField).val(doctorField.value).trigger('change');
            }
        }
        descriptionField.value = button.dataset.description || '';
        showModal(modal);
    };

    document.querySelectorAll('.edit-history').forEach((button) => {
        button.addEventListener('click', () => openModal(button));
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const url = form.dataset.updateUrl;
        const historyId = form.dataset.historyId;
        if (!url || !historyId) {
            Swal.fire({
                icon: 'error',
                title: getTranslation('errorTitle'),
                text: getTranslation('genericError'),
            });
            return;
        }

        const formData = new FormData(form);
        formData.set('_method', 'PUT');
        const csrfToken = getCsrfToken();
        if (csrfToken) {
            formData.set('_token', csrfToken);
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        })
            .then((resp) => resp.json().catch(() => ({})))
            .then((data) => {
                if (data?.success) {
                    updateHistoryRow(data.data);
                    hideModal(modal);
                    Swal.fire({
                        icon: 'success',
                        title: getTranslation('successTitle'),
                        text: getTranslation('updatedMessage') || getTranslation('genericSuccess', 'Updated'),
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    return;
                }
                if (data?.errors) {
                    const messages = Object.values(data.errors).flat();
                    Swal.fire({
                        icon: 'error',
                        title: getTranslation('errorTitle'),
                        text: messages[0] || getTranslation('genericError'),
                    });
                    return;
                }
                Swal.fire({
                    icon: 'error',
                    title: getTranslation('errorTitle'),
                    text: getTranslation('genericError'),
                });
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: getTranslation('errorTitle'),
                    text: getTranslation('genericError'),
                });
            });
    });
}

ready(() => {
    attachViewHandlers();
    attachDeleteHandlers();
    attachEditHandlers();
});
