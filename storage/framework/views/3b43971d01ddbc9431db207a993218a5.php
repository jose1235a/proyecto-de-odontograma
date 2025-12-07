<script>
window.patientShowConfig = {
    tabs: ['patient-info', 'consultations', 'odontograms', 'appointments', 'payments', 'images'],
    localStorageKey: 'patient_show_active_tab',
};


// Payment filters and export functions
function applyFilters() {
    const formData = new FormData(document.getElementById('payment-filters'));
    const params = new URLSearchParams();

    for (let [key, value] of formData.entries()) {
        if (value.trim() !== '') {
            params.append(key, value);
        }
    }

    // Reload the page with filters
    const currentUrl = new URL(window.location);
    currentUrl.search = params.toString();
    window.location.href = currentUrl.toString();
}

function clearFilters() {
    // Clear form fields
    document.getElementById('payment-filters').reset();

    // Reload page without filters
    const currentUrl = new URL(window.location);
    currentUrl.search = '';
    window.location.href = currentUrl.toString();
}

function exportPayments() {
    const formData = new FormData(document.getElementById('payment-filters'));
    const params = new URLSearchParams();

    // Add patient ID
    params.append('patient_id', '<?php echo e($patient->id); ?>');

    for (let [key, value] of formData.entries()) {
        if (value.trim() !== '') {
            params.append(key, value);
        }
    }

    // Open export URL in new tab
    const exportUrl = '<?php echo e(route("dental_management.payments.export_excel")); ?>?' + params.toString();
    window.open(exportUrl, '_blank');
}

const patientTabDataTableMap = {
    '#consultations': [{
        selector: '#patient-consultations-table',
        options: {
            order: [[0, 'desc']],
        },
    }],
    '#odontograms': [{
        selector: '[data-odontogram-list]',
        options: {
            order: [[0, 'desc']],
        },
    }],
    '#appointments': [{
        selector: '#patient-appointments-table',
        options: {
            order: [[0, 'desc']],
        },
    }],
    '#payments': [{
        selector: '#patient-payments-table',
        options: {
            order: [[0, 'desc']],
        },
    }],
    '#images': [{
        selector: '#patient-images-table',
        options: {
            order: [[0, 'desc']],
            columnDefs: [
                { targets: [3, 4], orderable: false, searchable: false },
            ],
        },
    }],
};

const dataTableLanguage = {
    search: '<?php echo e(__('global.datatable.search')); ?>',
    lengthMenu: '<?php echo e(__('global.datatable.length_menu')); ?>',
    zeroRecords: '<?php echo e(__('global.datatable.zero_records')); ?>',
    info: '<?php echo e(__('global.datatable.info')); ?>',
    infoEmpty: '<?php echo e(__('global.datatable.info_empty')); ?>',
    infoFiltered: '<?php echo e(__('global.datatable.info_filtered')); ?>',
    paginate: {
        next: '<?php echo e(__('global.datatable.next')); ?>',
        previous: '<?php echo e(__('global.datatable.previous')); ?>',
    },
};

function initPatientDataTables() {
    if (!window.jQuery || typeof $.fn.DataTable !== 'function') {
        return;
    }

    const defaultOptions = {
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo e(__('global.all')); ?>']],
        language: dataTableLanguage,
    };

    Object.values(patientTabDataTableMap).forEach((entries) => {
        (entries || []).forEach((entry) => {
            const selector = typeof entry === 'string' ? entry : entry?.selector;
            if (!selector) {
                return;
            }
            const $tables = $(selector);
            if (!$tables.length) {
                return;
            }
            $tables.each(function () {
                if ($.fn.dataTable.isDataTable(this)) {
                    return;
                }
                const customOptions = (typeof entry === 'object' && entry !== null) ? (entry.options || {}) : {};
                const tableOptions = $.extend(true, {}, defaultOptions, customOptions);
                $(this).DataTable(tableOptions);
            });
        });
    });
}

function adjustDataTablesForTab(tabSelector) {
    if (!window.jQuery || typeof $.fn.DataTable !== 'function') {
        return;
    }

    const entries = patientTabDataTableMap[tabSelector] || [];
    entries.forEach((entry) => {
        const selector = typeof entry === 'string' ? entry : entry?.selector;
        if (!selector) {
            return;
        }
        $(selector).each(function () {
            if ($.fn.dataTable.isDataTable(this)) {
                $(this).DataTable().columns.adjust();
            }
        });
    });
}

// Initialize when document is ready
$(document).ready(function() {
    // Set filter values from URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    urlParams.forEach((value, key) => {
        const element = document.querySelector(`[name="${key}"]`);
        if (element) {
            element.value = value;
        }
    });

    initPatientDataTables();

    $('a[data-toggle="pill"]').on('shown.bs.tab', function (event) {
        const target = event.target.getAttribute('href');
        adjustDataTablesForTab(target);
    });
});

</script>
<script type="module" src="<?php echo e(asset('adminlte/js/patient-show.js')); ?>"></script>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/partials/show_scripts.blade.php ENDPATH**/ ?>