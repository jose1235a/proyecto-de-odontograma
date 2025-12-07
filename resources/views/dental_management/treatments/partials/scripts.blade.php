<script>
$(document).ready(function() {
    // Initialize any table sorting or filtering if needed
    $('.table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
});
</script>