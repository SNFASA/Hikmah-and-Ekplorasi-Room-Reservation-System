@extends('backend.layouts.master')
@section('title','Schedule Reserved Room')
@section('main-content')
    <divc class="container mt-5">
        <div id="calendar" style="margin: 40px 30px 40px 30px;"></div>
    </divc>
@endsection
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
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
                eventColor: function(event) {
                    return event.color; // Set the color dynamically
                },
                eventRender: function(info) {
                    var tooltip = new Tooltip(info.el, {
                        title: info.event.extendedProps.title,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }
            });
            calendar.render();
        });
    </script>
@endpush
