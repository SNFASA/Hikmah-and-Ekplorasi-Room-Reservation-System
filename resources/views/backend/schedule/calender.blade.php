@extends('backend.layouts.master')
@section('title','Schedule Reserved Room')
@section('main-content')
    <divc class="container mt-5">
        <div id="calendar" style="margin: 40px 30px 40px 30px;"></div>
    </divc>
@endsection
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <style>
.fc-event {
    display: block;
}

.fc-event div {
    text-align: left;
}

    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        slotMinTime: '08:00:00',
        slotMaxTime: '19:00:00',
        events: @json($events), // Pass events from controller
        eventContent: function (info) {
            // Create a container for the event details
            var container = document.createElement('div');
            container.style.display = 'flex';
            container.style.flexDirection = 'column';
            container.style.alignItems = 'flex-start';
            container.style.padding = '5px';
            container.style.backgroundColor = info.event.backgroundColor || '#3788d8';
            container.style.borderRadius = '5px';
            container.style.marginBottom = '5px';

            // Create a time element
            var timeEl = document.createElement('div');
            timeEl.style.fontWeight = 'bold';
            timeEl.style.color = '#fff';
            timeEl.innerHTML = `${info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - 
                ${info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;

            // Create a title element
            var titleEl = document.createElement('div');
            titleEl.style.color = '#fff';
            titleEl.innerHTML = info.event.title || 'No Title';

            container.appendChild(timeEl);
            container.appendChild(titleEl);

            return { domNodes: [container] };
        },
        eventOverlap: false, // Prevent overlapping events visually
        slotEventOverlap: false, // Ensure no horizontal overlap
    });
    calendar.render();
});

    </script>
@endpush
