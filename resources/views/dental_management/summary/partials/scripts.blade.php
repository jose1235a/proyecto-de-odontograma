<script>
$(document).ready(function() {
    // Monthly Trends Chart
    var ctx = document.getElementById('monthlyTrendsChart').getContext('2d');
    var trendsData = @json($summary['monthly_trends']);

    var labels = Object.keys(trendsData);
    var appointmentsData = labels.map(month => trendsData[month].appointments);
    var paymentsData = labels.map(month => trendsData[month].payments);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '{{ __("dental_management.summary.appointments") }}',
                data: appointmentsData,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4
            }, {
                label: '{{ __("dental_management.summary.payments") }}',
                data: paymentsData,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: '{{ __("dental_management.summary.appointments") }}'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: '{{ __("dental_management.summary.revenue") }} (S/)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
});
</script>