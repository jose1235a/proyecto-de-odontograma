@push('scripts')
<script>
$(document).ready(function() {
    // Handle editable cell (amount field)
    $(document).on('blur', '.editable-cell', function() {
        const cell = $(this);
        const id = cell.data('id');
        const field = cell.data('field');
        const newValue = cell.text().trim();
        const originalValue = cell.data('original');

        // Only save if value changed
        if (newValue !== originalValue && newValue !== '') {
            saveField(id, field, newValue, cell);
        }
    });

    // Handle editable select (payment_method, status fields)
    $(document).on('change', '.editable-select', function() {
        const select = $(this);
        const id = select.data('id');
        const field = select.data('field');
        const newValue = select.val();
        const originalValue = select.data('original');

        // Only save if value changed
        if (newValue !== originalValue.toString()) {
            saveField(id, field, newValue, select);
        }
    });

    // Handle editable date (payment_date field)
    $(document).on('change', '.editable-date', function() {
        const input = $(this);
        const id = input.data('id');
        const field = input.data('field');
        const newValue = input.val();
        const originalValue = input.data('original');

        // Only save if value changed
        if (newValue !== originalValue) {
            saveField(id, field, newValue, input);
        }
    });

    // Common save function
    function saveField(id, field, value, element) {
        // Show loading state
        element.css('opacity', '0.6');

        $.ajax({
            url: "{{ route('dental_management.payments.update_inline') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                field: field,
                value: value
            },
            success: function(response) {
                if (response.success) {
                    // Success feedback
                    element.css({
                        'background-color': '#d4edda',
                        'opacity': '1'
                    });

                    // Update original value
                    element.data('original', value);

                    // Reset background after 2 seconds
                    setTimeout(function() {
                        element.css('background-color', '');
                    }, 2000);
                }
            },
            error: function(xhr) {
                // Error feedback
                element.css({
                    'background-color': '#f8d7da',
                    'opacity': '1'
                });

                // Reset background after 2 seconds
                setTimeout(function() {
                    element.css('background-color', '');
                }, 2000);

                console.error('Save error:', xhr.responseText);
            }
        });
    }

    // Handle Enter key in editable cells
    $(document).on('keydown', '.editable-cell', function(e) {
        if (e.keyCode === 13) { // Enter key
            e.preventDefault();
            $(this).blur(); // Trigger blur event
        }
    });
});
</script>

<style>
.editable-cell {
    cursor: pointer;
    min-height: 30px;
    padding: 8px;
    border: 1px solid transparent;
    transition: all 0.2s ease;
}

.editable-cell:hover {
    border-color: #dee2e6;
    background-color: #f8f9fa;
}

.editable-cell:focus {
    outline: none;
    border-color: #007bff;
    background-color: #fff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.editable-select {
    border: 1px solid transparent;
    transition: all 0.2s ease;
}

.editable-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.editable-date {
    border: 1px solid transparent;
    transition: all 0.2s ease;
}

.editable-date:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}
</style>
@endpush