@extends('frontend.layouts.master')
@section('title','Schedule Reserved Room')
@section('main-content')
    <div class="container-fluid mt-5 px-4">
        <div class="card shadow-sm border rounded p-4 w-100" style="min-height: 700px;">
            <div id="calendar" style="min-height: 650px;"></div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <style>
        .fc-event {
            display: block !important;
            width: 100% !important;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            transition: box-shadow 0.3s ease;
            cursor: pointer;
            padding: 6px 10px;
            color: #fff !important;
            box-sizing: border-box;
        }
        .fc-event:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .fc-event > div {
            width: 100% !important;
            padding: 0;
            margin: 0;
            text-align: left;
        }
        @media (max-width: 576px) {
            #calendar {
                font-size: 0.85rem;
            }
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
                events: @json($events),
                eventContent: function (info) {
                    var container = document.createElement('div');
                    container.style.display = 'flex';
                    container.style.flexDirection = 'column';
                    container.style.alignItems = 'flex-start';
                    container.style.width = '100%';
                    container.style.color = '#fff';
                    container.style.fontWeight = '500';

                    var timeEl = document.createElement('div');
                    timeEl.style.fontWeight = 'bold';
                    timeEl.textContent = `${info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;

                    var titleEl = document.createElement('div');
                    titleEl.textContent = info.event.title || 'No Title';

                    container.appendChild(timeEl);
                    container.appendChild(titleEl);

                    return { domNodes: [container] };
                },
                eventOverlap: false,
                slotEventOverlap: false,
                height: 'auto',
                nowIndicator: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
            });
            calendar.render();
        });
    </script>
@endpush
