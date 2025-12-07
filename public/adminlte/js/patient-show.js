function initPatientShow(config) {
        const storageKey = config.localStorageKey || 'patient_show_active_tab';
        const allowedTabs = config.tabs || [];

        function resolveActiveTab(urlTab, savedTab) {
            if (urlTab && allowedTabs.includes(urlTab)) {
                return urlTab;
            }

            if (savedTab && allowedTabs.includes(savedTab)) {
                return savedTab;
            }

            return allowedTabs[0] || null;
        }

        function showTab(tab) {
            if (!tab || tab === 'patient-info') {
                return;
            }

            const tabTrigger = document.getElementById(`${tab}-tab`);
            if (tabTrigger) {
                $(tabTrigger).tab('show');
            }
        }

        $(document).ready(function () {
            const params = new URLSearchParams(window.location.search);
            const tabFromUrl = params.get('tab');
            const savedTab = window.localStorage.getItem(storageKey);
            const activeTab = resolveActiveTab(tabFromUrl, savedTab);

            showTab(activeTab);

            $('a[data-toggle="pill"]').on('shown.bs.tab', function (event) {
                const targetTab = event.target.getAttribute('href').replace('#', '');
                window.localStorage.setItem(storageKey, targetTab);
            });

        });
    }

document.addEventListener('DOMContentLoaded', () => {
    if (window.patientShowConfig) {
        initPatientShow(window.patientShowConfig);
    }
});
