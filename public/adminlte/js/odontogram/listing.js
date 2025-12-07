(function (window, document, $) {
    function initOdontogramTables() {
        if (!$ || typeof $.fn.DataTable !== 'function') {
            return;
        }

        document.querySelectorAll('[data-odontogram-list]').forEach((table) => {
            $(table).DataTable({
                paging: false,
                lengthChange: false,
                searching: false,
                ordering: true,
                info: false,
                autoWidth: false,
                responsive: true,
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initOdontogramTables);
    } else {
        initOdontogramTables();
    }
})(window, document, window.jQuery);
