@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateValue(element, value) {
        if (element.hasClass('editable-cell')) {
            element.text(value);
        } else if (element.is('select')) {
            element.val(value);
        }
        element.data('original', value.toString());
    }

    function revertValue(element) {
        if (element.hasClass('editable-cell')) {
            element.text(element.data('original'));
        } else if (element.is('select')) {
            element.val(element.data('original'));
        }
    }

    function saveField(id, field, value, element) {
        element.css('opacity', '0.6');

        $.ajax({
            url: "{{ route('dental_management.appointments.update_inline') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                field: field,
                value: value
            },
            success: function (response) {
                element.css({
                    'background-color': '#d4edda',
                    'opacity': '1'
                });
                updateValue(element, response.value);
                setTimeout(function () {
                    element.css('background-color', '');
                }, 1500);
            },
            error: function () {
                element.css({
                    'background-color': '#f8d7da',
                    'opacity': '1'
                });
                revertValue(element);
                setTimeout(function () {
                    element.css('background-color', '');
                }, 1500);
            }
        });
    }

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

    $(document).on('keydown', '.editable-cell', function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            $(this).blur();
        }
    });
});
</script>
@endpush
