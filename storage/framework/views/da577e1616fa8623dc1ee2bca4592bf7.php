<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    
    if (!calendarEl) {
        console.error('Calendar element not found');
        return;
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: '<?php echo e(__("dental_management.calendar.button_today")); ?>',
            month: '<?php echo e(__("dental_management.calendar.button_month")); ?>',
            week: '<?php echo e(__("dental_management.calendar.button_week")); ?>',
            day: '<?php echo e(__("dental_management.calendar.button_day")); ?>',
            list: '<?php echo e(__("dental_management.calendar.button_list")); ?>'
        },
        dayMaxEventRows: 3,
        events: {
            url: '<?php echo e(route('dental_management.calendar.events')); ?>',
            method: 'GET'
        },
        eventDisplay: 'block',
        eventContent: function(arg) {
            const start = arg.event.start
                ? arg.event.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' })
                : '';
            const wrapper = document.createElement('div');
            wrapper.innerHTML = `
                <span class="fc-dental-event-time">${start}</span>
                <span class="fc-dental-event-title">${arg.event.title}</span>
            `;
            return { domNodes: [wrapper] };
        },
        eventDidMount: function(info) {
            const color = info.event.backgroundColor || '#117a8b';
            info.el.style.backgroundColor = color;
            info.el.style.borderColor = color;
            info.el.style.color = '#fff';
        },
        eventClick: function (info) {
            const event = info.event;
            const extended = event.extendedProps || {};
            const startTime = event.start ? event.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) : '';
            const endTime = event.end ? event.end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) : '';

            document.getElementById('eventModalTitleText').textContent = extended.patient || event.title;
            document.getElementById('eventDoctor').textContent = extended.doctor || '-';
            document.getElementById('eventTreatment').textContent = extended.treatment || '-';
            document.getElementById('eventTime').textContent = `${startTime}${endTime ? ' - ' + endTime : ''}`;
            document.getElementById('eventStatus').textContent = extended.status || '-';
            document.getElementById('eventNotes').textContent = extended.notes || '<?php echo e(__('global.none')); ?>';

            $('#eventModal').modal('show');
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        }
    });

    calendar.render();
    
    // Log para debugging
    console.log('FullCalendar initialized successfully');
});
</script>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/calendar/partials/scripts.blade.php ENDPATH**/ ?>