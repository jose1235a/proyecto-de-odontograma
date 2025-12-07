@push('scripts')
<script>
$(document).ready(function () {
    $(document).on('blur', '.editable-cell', function () {
        const cell = $(this);
        const id = cell.data('id');
        const field = cell.data('field');
        const newValue = cell.text().trim();
        const originalValue = cell.data('original').toString();

        if (newValue === '' || newValue === originalValue) {
            cell.text(originalValue);
            return;
        }

        saveField(id, field, newValue, cell);
    });

    $(document).on('change', '.editable-select', function () {
        const select = $(this);
        const id = select.data('id');
        const field = select.data('field');
        const newValue = select.val();
        const originalValue = select.data('original').toString();

        if (newValue === originalValue) {
            return;
        }

        saveField(id, field, newValue, select);
    });

    function saveField(id, field, value, element) {
        element.css('opacity', '0.6');

        $.ajax({
            url: "{{ route('dental_management.treatments.update_inline') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                field: field,
                value: value
            },
            success: function (response) {
                if (response.success) {
                    element.css({
                        'background-color': '#d4edda',
                        'opacity': '1'
                    });

                    const updatedValue = response.value;

                    if (element.hasClass('editable-cell') && field === 'cost') {
                        element.text(parseFloat(updatedValue).toFixed(2));
                    } else if (element.hasClass('editable-cell')) {
                        element.text(updatedValue);
                    } else if (element.is('select')) {
                        element.val(updatedValue);
                    }

                    element.data('original', updatedValue.toString());

                    setTimeout(function () {
                        element.css('background-color', '');
                    }, 2000);
                }
            },
            error: function () {
                element.css({
                    'background-color': '#f8d7da',
                    'opacity': '1'
                });

                if (element.hasClass('editable-cell')) {
                    element.text(element.data('original'));
                } else if (element.is('select')) {
                    element.val(element.data('original'));
                }

                setTimeout(function () {
                    element.css('background-color', '');
                }, 2000);
            }
        });
    }

    $(document).on('keydown', '.editable-cell', function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            $(this).blur();
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
</style>
@endpush
