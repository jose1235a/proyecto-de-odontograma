<script>
$(document).ready(function() {
    // Payment Methods Chart
    var ctx = document.getElementById('paymentMethodsChart').getContext('2d');
    var paymentData = @json($stats['by_method']);

    var labels = Object.keys(paymentData);
    var data = Object.values(paymentData);

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels.map(method => {
                switch(method) {
                    case 'cash': return '{{ __("dental_management.payments.method_cash") }}';
                    case 'card': return '{{ __("dental_management.payments.method_card") }}';
                    case 'transfer': return '{{ __("dental_management.payments.method_transfer") }}';
                    case 'check': return '{{ __("dental_management.payments.method_check") }}';
                    default: return method;
                }
            }),
            datasets: [{
                data: data,
                backgroundColor: [
                    '#28a745', // cash
                    '#007bff', // card
                    '#17a2b8', // transfer
                    '#ffc107'  // check
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>